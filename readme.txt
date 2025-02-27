For laravel 11
add below in bootstrap/app.php

    ->withProviders([
        App\Providers\AppServiceProvider::class,
       
    ])->create();

For main laravel application service provider under boot method add below

$this->app->make('stackcue-zat2')->setSaasCompanyIdCallback(function () {
    $saas_company_id = 1; // Replace this with dynamic logic (e.g., database query)

    return $saas_company_id;
});

$this->app->make('stackcue-zat2')->setUserIDCallback(function () {
    $user_id = 1; // Replace this with dynamic logic (e.g., database query)

    return $user_id;
});


the value will available anywhere in application including library

$company_id = app('stackcue-zat2')->getSaasCompanyId(); and
$user_id = app('stackcue-zat2')->getuserID();