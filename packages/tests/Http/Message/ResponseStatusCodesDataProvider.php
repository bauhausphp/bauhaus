<?php

namespace Bauhaus\Tests\Http\Message;

trait ResponseStatusCodesDataProvider
{
    public function validStatusCodes(): array
    {
        $mapped = [];
        foreach ($this->validStatusCodesData() as $code => $reasonPhrase) {
            $mapped["code $code"] = [$code, $reasonPhrase];
        }

        return $mapped;
    }

    public function invalidStatusCodes(): array
    {
        $mapped = [];
        foreach ($this->invalidStatusCodesData() as $code) {
            $mapped["code $code"] = [$code];
        }

        return $mapped;
    }

    private function validStatusCodesData(): array
    {
        return [
            200 => 'Ok',
            404 => 'Not Found',
        ];
    }

    private function invalidStatusCodesData(): array
    {
        return [-100, -1, 0, 1, 99, 600, 601, 666];
    }
}
