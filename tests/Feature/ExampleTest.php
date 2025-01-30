<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    // If there isn't any poll in the database, the response will be a redirect to the login page
    $this->assertContains($response->getStatusCode(), [200, 302]);
});
