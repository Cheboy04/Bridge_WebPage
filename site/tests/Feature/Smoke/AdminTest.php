<?php

// BRG-5 (brg-31) · spec docs/specs/brg-31.md §4 · tests 2 and 3

it('shows the admin login to guests', function () {
    $this->get('/admin/login')
        ->assertOk()
        ->assertSee('type="email"', false);
});

it('redirects guests from the admin to the login', function () {
    $this->get('/admin')->assertRedirect('/admin/login');
});
