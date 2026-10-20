<?php

// BRG-5 (brg-31) · spec docs/specs/brg-31.md §4 · test 2 (test 3 moved to tests/Feature/Admin/AccessTest.php, brg-02)

it('shows the admin login to guests', function () {
    $this->get('/admin/login')
        ->assertOk()
        ->assertSee('type="email"', false);
});
