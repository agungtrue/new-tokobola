<?php

class MessageTest extends TestCase
{
    /** @test **/
    public function helpersMessage()
    {
        $this->assertEquals('Nama wajib diisi.',
            message('validation.required', ['attribute' => 'name'], 'id')
        );
    }
}
