<?php

namespace App\Tests\IntegrationTests;

use App\Infrastructure\Test\IntegrationTestCase;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationTest extends IntegrationTestCase
{

    public function testSuccessful()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/registration');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter("form")->form(
            [
                "registration[pseudo]"                => "usedaaaa",
                "registration[firstname]"             => "mourad",
                "registration[lastname]"              => "chabour",
                "registration[email]"                 => "new_used@email.com",
                "registration[plainPassword][first]"  => "test1234",
                "registration[plainPassword][second]" => "test1234",
            ]
        );

        $client->submit($form);


        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }


    /**
     * @dataProvider provideFormData
     *
     * @param string $pseudo
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param array  $plainPassword
     * @param string $errorMessage
     */
    public function testFailed(
        string $pseudo,
        string $firstName,
        string $lastName,
        string $email,
        array $plainPassword,
        string $errorMessage
    ) {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/registration');

        $this->assertResponseIsSuccessful();

        $form = $crawler
            ->filter("form")
            ->form(
                [
                    "registration[pseudo]"                => $pseudo,
                    "registration[firstname]"             => $firstName,
                    "registration[lastname]"              => $lastName,
                    "registration[email]"                 => $email,
                    "registration[plainPassword][first]"  => $plainPassword["first"],
                    "registration[plainPassword][second]" => $plainPassword["second"],
                ]
            );

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorTextContains('html', $errorMessage);
    }

    /**
     * @return Generator
     */
    public function provideFormData(): Generator
    {
        yield [
            "pseudo",
            "",
            "chabour",
            "email@email.com",
            ["first" => "password", "second" => "password"],
            "This value should not be blank.",
        ];

        yield [
            "pseudo",
            "mourad",
            "",
            "email@email.com",
            ["first" => "password", "second" => "password"],
            "This value should not be blank.",
        ];

        yield [
            "",
            "mourad",
            "chabour",
            "email@email.com",
            ["first" => "password", "second" => "password"],
            "This value should not be blank.",
        ];

        yield [
            "pseudo",
            "mourad",
            "chabour",
            "",
            ["first" => "password", "second" => "password"],
            "This value should not be blank.",
        ];

        yield [
            "pseudo",
            "mourad",
            "chabour",
            "fail",
            ["first" => "password", "second" => "password"],
            "This value is not a valid email address.",
        ];


        yield [
            "pseudo",
            "mourad",
            "chabour",
            "email@email.com",
            ["first" => "", "second" => ""],
            "This value should not be blank.",
        ];

        yield [
            "pseudo",
            "mourad",
            "chabour",
            "email@email.com",
            ["first" => "fail", "second" => "fail"],
            "This value is too short. It should have 8 characters or more.",
        ];

        yield [
            "pseudo",
            "mourad",
            "chabour",
            "email@email.com",
            ["first" => "password", "second" => "fail_password"],
            "The password confirmation must be similar to the password.",
        ];

        yield [
            "used",
            "mourad",
            "chabour",
            "new_user@email.com",
            ["first" => "password", "second" => "password"],
            "This pseudo address already exists.",
        ];

        yield [
            "pseudo",
            "mourad",
            "chabour",
            "used@email.com",
            ["first" => "password", "second" => "password"],
            "This email address already exists.",
        ];
    }
}
