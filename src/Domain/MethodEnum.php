<?php

namespace App\Domain;

enum MethodEnum: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
    case HEAD = 'HEAD';
    case OPTIONS = 'OPTIONS';
    case CONNECT = 'CONNECT';
    case TRACE = 'TRACE';
}