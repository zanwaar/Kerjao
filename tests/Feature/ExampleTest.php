<?php

test('guests are redirected to the login page from the dashboard', function () {
    $this->get('/')->assertRedirect(route('login'));
});
