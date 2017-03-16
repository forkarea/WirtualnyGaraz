<?php

namespace PioCMS\Engine\Router;

use PioCMS\Engine\URL;

class Routes {

    public static $routes = array();

    public static function init() {
        Routes::get('/error_404', ['uses' => 'Page@error_404', 'name' => 'error_404']);
        Routes::post('/rejestracja', ['uses' => 'User@register_form', 'name' => 'user_register']);
        Routes::get('/rejestracja', ['uses' => 'User@register', 'name' => 'user_register']);
        Routes::get('/logowanie', ['uses' => 'User@login', 'name' => 'user_login']);
        Routes::post('/logowanie', ['uses' => 'User@login_form', 'name' => 'user_login']);
        Routes::post('/login/gcm', ['uses' => 'User@login_form_gcm', 'name' => 'login_form_gcm']);
        Routes::post('/user/get_info', ['uses' => 'User@get_user_info', 'name' => 'get_user_info']);
        Routes::post('/rejestracja/gcm', ['uses' => 'User@register_form_gcm', 'name' => 'register_form_gcm']);
        Routes::get('/wyloguj', ['uses' => 'User@logout', 'name' => 'user_logout']);
        Routes::get('/przypomnij-haslo', ['uses' => 'User@forgot', 'name' => 'user_forgot_password']);
        Routes::post('/przypomnij-haslo', ['uses' => 'User@forgot_form', 'name' => 'user_forgot_password']);
        Routes::post('/przypomnij-haslo/gcm', ['uses' => 'User@forgot_form_gcm', 'name' => 'user_forgot_password_gcm']);
        Routes::get('/profil', ['uses' => 'Page@pages', 'name' => 'user_profile']);
        Routes::get('/profil/edycja', ['uses' => 'User@profile_edit', 'name' => 'profile_edit']);
        Routes::post('/profil/edycja', ['uses' => 'User@profile_edit_form', 'name' => 'profile_edit']);
        Routes::get('/', ['uses' => 'Home@index', 'name' => 'home']);
        Routes::get('/lista', ['uses' => 'Garage@index', 'name' => 'garage']);
        Routes::post('/lista', ['uses' => 'Garage@index', 'name' => 'garage']);
        Routes::get('/lista/{page}', ['uses' => 'Garage@index', 'name' => 'garageList'])->where('page', '[0-9]+');
        Routes::get('/dodaj/pojazd', ['uses' => 'Garage@vehicle_add', 'name' => 'vehicle_add']);
        Routes::post('/dodaj/pojazd', ['uses' => 'Garage@vehicle_add_form', 'name' => 'vehicle_add']);
        Routes::get('/edytuj/pojazd/{id}', ['uses' => 'Garage@vehicle_edit', 'name' => 'vehicle_edit'])->where('id', '[0-9]+');
        Routes::post('/edytuj/pojazd/{id}', ['uses' => 'Garage@vehicle_edit_form', 'name' => 'vehicle_edit'])->where('id', '[0-9]+');
        Routes::post('/usun/pojazd/{id}', ['uses' => 'Garage@vehicle_remove', 'name' => 'vehicle_remove'])->where('id', '[0-9]+');
        Routes::get('/pojazd/{alias}/{id}', ['uses' => 'Garage@vehicle_info', 'name' => 'vehicle_info'])->where('id', '[0-9]+')->where('alias', '[a-z-0-9]+');
        Routes::get('/dodaj/zdjecia/{vehicle_id}', ['uses' => 'Gallery@vehicle_gallery_add', 'name' => 'vehicle_add_photo'])->where('vehicle_id', '[0-9]+');
        Routes::post('/dodaj/zdjecie', ['uses' => 'Gallery@photo_post', 'name' => 'photo_post']);
        Routes::post('/usun/zdjecie', ['uses' => 'Gallery@photo_delete', 'name' => 'photo_delete']);
        Routes::get('/dodaj/tankowanie/{id}', ['uses' => 'Garage@refuel_add', 'name' => 'refuel_add'])->where('id', '[0-9]+');
        Routes::get('/pojazd/{alias}/tankowania/{id}', ['uses' => 'Garage@vehicle_refuel_info', 'name' => 'vehicle_refuel_info'])->where('id', '[0-9]+')->where('alias', '[a-z-0-9]+');
        Routes::get('/pojazd/{alias}/naprawy/{id}', ['uses' => 'Garage@vehicle_repair_info', 'name' => 'vehicle_repair_info'])->where('id', '[0-9]+')->where('alias', '[a-z-0-9]+');
        Routes::post('/dodaj/tankowanie/{id}', ['uses' => 'Garage@refuel_add_form', 'name' => 'refuel_add'])->where('id', '[0-9]+');
        Routes::get('/usun/tankowanie/{id}', ['uses' => 'Garage@refuel_delete', 'name' => 'refuel_delete'])->where('id', '[0-9]+');
        Routes::get('/dodaj/naprawe/{id}', ['uses' => 'Garage@repair_add', 'name' => 'repair_add'])->where('id', '[0-9]+');
        Routes::post('/dodaj/naprawe/{id}', ['uses' => 'Garage@repair_add_form', 'name' => 'repair_add'])->where('id', '[0-9]+');
        Routes::get('/usun/naprawe/{id}', ['uses' => 'Garage@repair_delete', 'name' => 'repair_delete'])->where('id', '[0-9]+');

        Routes::get('/test/{name}', function($name) {
            print $name;
        })->where('name', '[0-9a-z]+');
    }

    public static function get($uri, $action = null) {
        return new Route('get', $uri, $action);
    }

    public static function post($uri, $action = null) {
        return new Route('post', $uri, $action);
    }

}
