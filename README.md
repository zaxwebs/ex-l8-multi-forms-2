<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Introduction

In this post, I'd like to explain my process of handling & validating multiple forms that can have same-named fields. For example, you can have two side by side forms, say, login and signup on the same page. And you are likely to have matching fields like username, password, and such. If you use something like `old('username')` as the value, the respective fields of both forms would be populated even if you submitted just one.

# The Product
![Alt Text](https://dev-to-uploads.s3.amazonaws.com/i/yr98zcpxbxf9v9s1tsdh.gif)

Disclaimer: This is experimental at the moment, I'm still refining my procedure and looking into other ideas. This is a journal of what I have come up with so far.

Alright, let's get down to it.

# The Flow
1. I add a hidden field called `_name` to my forms. Which holds an identifier for the form e.g `login`, `signup`, etc.
2. On the controller side there is no change, yet. The validation logic stays the same.
3. Before utilizing the old value of, say, username field. I check if the old value of `_name` is the same as defined earlier.

# The Setup

As you might guess this adds some repetition to the forms and I like to keep things DRY. For this, we do have components to the rescue. Note, how flexible you make them is up to you.

```php
<?PHP

// app/View/Components/Input.php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $id;
    public $type;
    public $label;
    public $form;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name= null, $id = null, $type=null, $label='text', $form = null)
    {
        //
        $this->name= $name;
        $this->id= $id ? $id : ($form && $name ? $form . '-' . $name : null);
        $this->type= $type;
        $this->label= $label;
        $this->form= $form;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.input');
    }
}
```

Wouldn't it be good to have some helpers to perform the checks? For this, I set up custom blade directives that handle checking the conditionals.
```php
<?php

// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('from', function ($form = null) {
            return old('_name') === $form;
        });

        Blade::if('invalid', function ($name, $form = null) {
            $errors = session()->get('errors', app(ViewErrorBag::class));
            return old('_name') === $form && $errors->has($name);
        });
    }
}

```

Here's how my InputComponent view looks like:
```php
<div class="mb-3">
    @if($label)
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" class="form-control @invalid($name, $form) is-invalid @endinvalid" id="{{ $id }}"
        name="{{ $name }}" value="@from($form){{ old($name) }}@endfrom($form)" />
    @invalid($name, $form)
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
    @endinvalid
</div>
```

I also utilize a Form component to handle adding the hidden input field as well as automate handling the method for it.

# Summary
This is just one of perhaps many more solutions out there. This works for me at the moment and I will still continue to explore more.
Thank you for reading.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
