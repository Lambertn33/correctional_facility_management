<?php 
 namespace App\Http\Services\Common\Videos;
 use Firebase\JWT\JWT;
 use Illuminate\Support\Str;
 use DateTimeImmutable;
 require __DIR__ . '../../../../../../vendor/autoload.php';

 class TokensGenerating {
    
    public function generateToken($isManagementToken) {
        $token = "";

        if ($isManagementToken) {
            $app_access_key = env('100MS_APP_ACCESS_KEY');
            $app_secret = env('100MS_APP_SECRET');
            $issuedAt   = new DateTimeImmutable();
            $expire     = $issuedAt->modify('+24 hours')->getTimestamp();
        
            $payload = [
                'access_key' => $app_access_key,
                'type' => 'management',
                'version' => 2,
                'jti' => Str::uuid()->toString(),
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
            $role      = "new-role-9900";
            $roomId    = "633c32bce08863a3f2f7facf";
            $userId    = "123";
            $issuedAt   = new DateTimeImmutable();
            $expire     = $issuedAt->modify('+24 hours')->getTimestamp();

            $payload = [
                'iat'  => $issuedAt->getTimestamp(),
                'nbf'  => $issuedAt->getTimestamp(),
                'exp'  => $expire,
                'access_key' => $app_access_key,
                'type' => $type,
                'jti' => Str::uuid()->toString(),
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