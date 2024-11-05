<?php

// Start a session if one hasn't been

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
