<?php 
 namespace App\Http\Services\Common\Videos;
 use Firebase\JWT\JWT;
 use DateTimeImmutable;
 use Ramsey\Uuid\Uuid;
 require __DIR__ . '../../../../../../vendor/autoload.php';

 class TokensGenerating {
    
    public function generateToken($isManagementToken, $isInmate, $room=null) {
        $token = "";
        $randomNumber = rand(1,9999999999);

        if ($isManagementToken) {
            $app_access_key = env('100MS_APP_ACCESS_KEY');
            $app_secret = env('100MS_APP_SECRET');
            $issuedAt   = new DateTimeImmutable();
            $expire     = $issuedAt->modify('+24 hours')->getTimestamp();
        
            $payload = [
                'access_key' => $app_access_key,
                'type' => 'management',
                'version' => 2,
                'jti' => Uuid::uuid4()->toString(),
                'iat'  => $issuedAt->getTimestamp(),
                'nbf'  => $issuedAt->getTimestamp(),
                'exp'  => $expire,
            ];
        
            $token = JWT::encode($payload, $app_secret, 'HS256');
        } else {
            $app_access_key = env('100MS_APP_ACCESS_KEY');
            $app_secret = env('100MS_APP_SECRET');
            $version   = 2;
            $type      = "app";
            $role      = $isInmate ? "prisoner" : "visitor";
            $roomId    = $room;
            $userId    = (string) $randomNumber;
            $issuedAt   = new DateTimeImmutable();
            $expire     = $issuedAt->modify('+24 hours')->getTimestamp();

            $payload = [
                'iat'  => $issuedAt->getTimestamp(),
                'nbf'  => $issuedAt->getTimestamp(),
                'exp'  => $expire,
                'access_key' => $app_access_key,
                'type' => $type,
                'jti' => Uuid::uuid4()->toString(),
                'version' => $version,
                'role' => $role,
                'room_id' => $roomId,
                'user_id' => $userId
            ];

            $token = JWT::encode($payload, $app_secret, 'HS256');
        }
        return $token;
    }
}

?>