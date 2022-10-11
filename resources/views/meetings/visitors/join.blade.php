<!DOCTYPE html>
<html>

<head>
  <title>PRISONS</title>
  <meta charset="UTF-8" />
</head>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
      Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
      background-image: url("/assets/images/login-images/bg-forgot-password.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
  }
  
  h1,
  h2,
  h3,
  h4,
  h5 {
    font-weight: normal;
  }
  
  header {
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #fff;
  }
  
  form {
    max-width: 450px;
    margin: 30px auto;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    border-radius: 8px;
    padding: 20px;
    background-color: #fff;
  }
  
  input {
    display: block;
    width: 100%;
    border-radius: 8px;
    border: 2px solid transparent;
    height: 34px;
    padding: 5px;
    background: #d9d9d9;
    color: inherit;
    font-family: inherit;
  }
  
  input::placeholder {
    color: #aaa;
  }
  
  .input-container {
    margin-bottom: 20px;
  }
  
  .btn-success,
  .btn-primary
  {
    border: 1px solid transparent;
    border-radius: 4px;
    text-decoration: none;
    padding: 6px 14px;
    color: white;
    font-family: inherit;
    font-size: 14px;
  }

  .btn-primary {
    background-color: #1565c0;
    cursor: pointer;
  }
  .btn-success {
    background-color: #006600;
  }
  
  form h2,
  .conference-section h2 {
    margin-bottom: 20px;
  }
  form h2 {
    color: #000;
    font-weight: 600;
    text-align: center;
  }

  .conference-section h2 {
    font-weight: 600;
    color: #fff;
  }
  
  .btn-danger {
    border: 1px solid transparent;
    border-radius: 4px;
    padding: 6px 14px;
    background-color: #f44336;
    color: white;
    font-family: inherit;
    font-size: 14px;
  }
  
  .conference-section {
    padding: 20px 30px;
    max-width: 960px;
    margin: 0 auto;
  }
  
  .conference-section h2 {
    text-align: center;
    font-size: 32px;
    padding-bottom: 10px;
    border-bottom: 1px solid #fff;
  }
  
  #peers-container {
    display: grid;
    grid-template-columns: repeat(3, minmax(min-content, 1fr));
    place-items: center;
    grid-gap: 10px;
  }
  
  .peer-video {
    height: 250px;
    width: 250px;
    border-radius: 40%;
    object-fit: cover;
    margin-bottom: 10px;
  }
  
  .local.peer-video {
    transform: scaleX(-1);
  }
  
  .peer-name {
    font-size: 14px;
    text-align: center;
    color: #fff;
    font-weight: 600;
  }
  
  .peer-container {
    padding: 10px;
  }
  
  .control-bar {
    display: flex;
    position: fixed;
    bottom: 0;
    width: 100%;
    padding: 15px;
    justify-content: center;
    z-index: 10;
  }
  
  .control-bar > *:not(:first-child) {
    margin-left: 8px;
  }
  
  .btn-control {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: 2px solid #37474f;
    width: 64px;
    height: 64px;
    border-radius: 50%;
    text-align: center;
    background-color: #607d8b;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
    color: white;
  }
  
  .hide {
    display: none;
  }
  
</style>

<body>
  <header>
    <img class="logo" src="/assets/images/logo-e-huza.png" width="80" />
    <button id="leave-btn" class="btn-danger hide">Leave Meeting</button>
  </header>
  <form id="join">
    <h2>Join Meeting</h2>
    <div class="input-container">
      <input id="name" type="text" disabled name="username" value="{{$userType === 'INMATE' ? $meetingInfo->appointment->inmate->names : $meetingInfo->appointment->names}}" />
    </div>
    <div class="input-container">
      <input id="token" type="hidden" name="token" value="{{$userType === 'INMATE' ? $meetingInfo->inmate_token : $meetingInfo->visitor_token}}" />
    </div>
    <button type="button" class="btn-primary" id="join-btn">
      Join
    </button>
    <a href="{{route('provideNationalId')}}" class="btn-success">Back</a>
  </form>

  <div id="conference" class="conference-section hide">
    <h2>Meeting with {{$userType === 'INMATE' ? $meetingInfo->appointment->names : $meetingInfo->appointment->inmate->names}}</h2>

    <div id="peers-container"></div>
  </div>

  <div id="controls" class="control-bar hide">
    <button id="mute-aud" class="btn-control">Mute</button>
    <button id="mute-vid" class="btn-control">Hide</button>
  </div>
</body>
<script type="module">
    import {
        HMSReactiveStore,
        selectIsConnectedToRoom,
        selectIsLocalAudioEnabled,
        selectIsLocalVideoEnabled,
        selectPeers
      } from "https://cdn.skypack.dev/@100mslive/hms-video-store";

      window.onbeforeunload = function() {
        return "Dude, are you sure you want to leave? Think of the kittens!";
    }
      
      // Initialize HMS Store
      const hmsManager = new HMSReactiveStore();
      hmsManager.triggerOnSubscribe();
      const hmsStore = hmsManager.getStore();
      const hmsActions = hmsManager.getHMSActions();
      
      // HTML elements
      const form = document.getElementById("join");
      const joinBtn = document.getElementById("join-btn");
      const conference = document.getElementById("conference");
      const peersContainer = document.getElementById("peers-container");
      const leaveBtn = document.getElementById("leave-btn");
      const muteAud = document.getElementById("mute-aud");
      const muteVid = document.getElementById("mute-vid");
      const controls = document.getElementById("controls");

      // btn styles
      function btnStyles(isJoining) {
        if (isJoining) {
          joinBtn.innerHTML = 'joining...';
          joinBtn.style.background = '#66e0ff';
        } else {
          joinBtn.innerHTML = 'join';
          joinBtn.style.background = '#1565c0';
        }
      }
      
      // Joining the room
      joinBtn.addEventListener("click", () => {
        btnStyles(true);
        hmsActions.join({
          userName: document.getElementById("name").value,
          authToken: document.getElementById("token").value
        });
      });
      
      // Leaving the room
      function leaveRoom() {
        btnStyles(false);
        hmsActions.leave();
        document.getElementById("token").value = "";
      }
      
      // Cleanup if user refreshes the tab or navigates away
      window.onunload = window.onbeforeunload = leaveRoom;
      leaveBtn.addEventListener("click", function(){
        let message = confirm('are you sure you want to leave the meeting ?');
        if (message == true) {
          leaveRoom();
        }
      });
      
      // helper function to create html elements
      function h(tag, attrs = {}, ...children) {
        const newElement = document.createElement(tag);
      
        Object.keys(attrs).forEach((key) => {
          newElement.setAttribute(key, attrs[key]);
        });
      
        children.forEach((child) => {
          newElement.append(child);
        });
      
        return newElement;
      }
      
      // display a tile for each peer in the peer list
      function renderPeers(peers) {
        peersContainer.innerHTML = "";
      
        if (!peers) {
          // this allows us to make peer list an optional argument
          peers = hmsStore.getState(selectPeers);
        }
      
        peers.forEach((peer) => {
          if (peer.videoTrack) {
            const video = h("video", {
              class: "peer-video" + (peer.isLocal ? " local" : ""),
              autoplay: true, // if video doesn't play we'll see a blank tile
              muted: true,
              playsinline: true
            });
      
            // this method takes a track ID and attaches that video track to a given
            // <video> element
            hmsActions.attachVideo(peer.videoTrack, video);
      
            const peerContainer = h(
              "div",
              {
                class: "peer-container"
              },
              video,
              h(
                "div",
                {
                  class: "peer-name"
                },
                peer.name + (peer.isLocal ? " (You)" : "")
              )
            );
      
            peersContainer.append(peerContainer);
            console.log('peer is' .peer);
          }
        });
      }
      
      function onConnection(isConnected) {
        if (isConnected) {
          form.classList.add("hide");
          conference.classList.remove("hide");
          leaveBtn.classList.remove("hide");
          controls.classList.remove("hide");
        } else {
          form.classList.remove("hide");
          conference.classList.add("hide");
          leaveBtn.classList.add("hide");
          controls.classList.add("hide");
        }
      }
      
      // reactive state - renderPeers is called whenever there is a change in the peer-list
      hmsStore.subscribe(renderPeers, selectPeers);
      
      // listen to the connection state
      hmsStore.subscribe(onConnection, selectIsConnectedToRoom);
      
      muteAud.addEventListener("click", () => {
        const audioEnabled = !hmsStore.getState(selectIsLocalAudioEnabled);
      
        hmsActions.setLocalAudioEnabled(audioEnabled);
      
        muteAud.textContent = audioEnabled ? "Mute" : "Unmute";
      });
      
      muteVid.addEventListener("click", () => {
        const videoEnabled = !hmsStore.getState(selectIsLocalVideoEnabled);
      
        hmsActions.setLocalVideoEnabled(videoEnabled);
      
        muteVid.textContent = videoEnabled ? "Hide" : "Unhide";
      
        // Re-render video tile
        renderPeers();
      });
      
</script>
</html>