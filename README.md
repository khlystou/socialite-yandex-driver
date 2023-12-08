# Yandex driver for Laravel socialite package

### Installation

```bash
composer require khlystou/socialite-yandex-driver
```

### Add configuration to `config/services.php`

```php
'yandex' => [    
    'client_id' => env('YANDEX_CLIENT_ID'),  
    'client_secret' => env('YANDEX_CLIENT_SECRET'),  
    'redirect' => env('YANDEX_REDIRECT') 
],
```

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
class AuthController extends Controller
{
    // some code...

    public function redirect(): RedirectResponse
    {
        return Socialite::driver('yandex')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('yandex')->user();

        // some code...
    }

    // some code...
}
```

### Returned User fields

- ``id``
- ``nickname``
- ``name``
- ``email``
- ``avatar``
