<?php

namespace Bauhaus\Tests\Http\Message\Response;

trait StatusDataProvider
{
    public function invalidStatusCodes(): iterable
    {
        foreach ([-100, -1, 0, 1, 99, 600, 601, 666] as $code) {
            yield "code $code" => [$code];
        }
    }

    public function validStatusCodes(): iterable
    {
        foreach ([100, 101, 200, 201, 299, 300, 500, 501, 599] as $code) {
            yield "code $code" => [$code];
        }
    }

    public function statusCodesWithIanaReasonPhrases(): iterable
    {
        yield "100" => [100, 'Continue'];
        yield "101" => [101, 'Switching Protocols'];
        yield "102" => [102, 'Processing'];
        yield "200" => [200, 'OK'];
        yield "201" => [201, 'Created'];
        yield "202" => [202, 'Accepted'];
        yield "203" => [203, 'Non-Authoritative Information'];
        yield "204" => [204, 'No Content'];
        yield "205" => [205, 'Reset Content'];
        yield "206" => [206, 'Partial Content'];
        yield "207" => [207, 'Multi-Status'];
        yield "208" => [208, 'Already Reported'];
        yield "226" => [226, 'IM Used'];
        yield "300" => [300, 'Multiple Choices'];
        yield "301" => [301, 'Moved Permanently'];
        yield "302" => [302, 'Found'];
        yield "303" => [303, 'See Other'];
        yield "304" => [304, 'Not Modified'];
        yield "305" => [305, 'Use Proxy'];
        yield "307" => [307, 'Temporary Redirect'];
        yield "308" => [308, 'Permanent Redirect'];
        yield "400" => [400, 'Bad Request'];
        yield "401" => [401, 'Unauthorized'];
        yield "402" => [402, 'Payment Required'];
        yield "403" => [403, 'Forbidden'];
        yield "404" => [404, 'Not Found'];
        yield "405" => [405, 'Method Not Allowed'];
        yield "406" => [406, 'Not Acceptable'];
        yield "407" => [407, 'Proxy Authentication Required'];
        yield "408" => [408, 'Request Timeout'];
        yield "409" => [409, 'Conflict'];
        yield "410" => [410, 'Gone'];
        yield "411" => [411, 'Length Required'];
        yield "412" => [412, 'Precondition Failed'];
        yield "413" => [413, 'Payload Too Large'];
        yield "414" => [414, 'URI Too Long'];
        yield "415" => [415, 'Unsupported Media Type'];
        yield "416" => [416, 'Range Not Satisfiable'];
        yield "417" => [417, 'Expectation Failed'];
        yield "421" => [421, 'Misdirected Request'];
        yield "422" => [422, 'Unprocessable Entity'];
        yield "423" => [423, 'Locked'];
        yield "424" => [424, 'Failed Dependency'];
        yield "426" => [426, 'Upgrade Required'];
        yield "428" => [428, 'Precondition Required'];
        yield "429" => [429, 'Too Many Requests'];
        yield "431" => [431, 'Request Header Fields Too Large'];
        yield "451" => [451, 'Unavailable For Legal Reasons'];
        yield "500" => [500, 'Internal Server Error'];
        yield "501" => [501, 'Not Implemented'];
        yield "502" => [502, 'Bad Gateway'];
        yield "503" => [503, 'Service Unavailable'];
        yield "504" => [504, 'Gateway Timeout'];
        yield "505" => [505, 'HTTP Version Not Supported'];
        yield "506" => [506, 'Variant Also Negotiates'];
        yield "507" => [507, 'Insufficient Storage'];
        yield "508" => [508, 'Loop Detected'];
        yield "510" => [510, 'Not Extended'];
        yield "511" => [511, 'Network Authentication Required'];
    }
}
