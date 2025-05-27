<?php

namespace App\Enums;

enum HttpStatus: int
{
    case OK = 200;
    case CREATED = 201;
    case UNAUTHORIZED = 401;
    case NOT_FOUND = 404;
    case INTERNAL_SERVER_ERROR = 500;
}
