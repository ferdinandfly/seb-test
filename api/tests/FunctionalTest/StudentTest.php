<?php


namespace App\Tests\FunctionalTest;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Student;

class StudentTest extends ApiTestCase
{
    public function testCreateStudent(): string
    {
        $response = static::createClient()->request('POST', '/students', ['json' => [
            'firstName' => 'TestFirstName',
            'lastName' => 'TestLastName',
            'birthDay' => '2021-02-01T18:01:20.973Z',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            "@context" => "/contexts/Student",
            "@type" => "Student",
            "firstName" => "TestFirstName",
            "lastName" => "TestLastName",
            "birthDay" => "2021-02-01T18:01:20+00:00"
        ]);
        $studentId = $response->toArray()['@id'];
        $this->assertMatchesRegularExpression('~^/students/\d+$~', $response->toArray($studentId)['@id']);
        $this->assertMatchesResourceItemJsonSchema(Student::class);

        return $studentId;
    }

    /**
     * @depends testCreateStudent
     */
    public function testUpdateStudent(string $studentId): string
    {
        $client = static::createClient();

        $client->request('PUT', $studentId, ['json' => [
            'firstName' => 'updatedFirstName',
        ]]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $studentId,
            'firstName' => 'updatedFirstName',
        ]);

        return $studentId;
    }

    /**
     * @depends testUpdateStudent
     */
    public function testGetStudent(string $studentId)
    {

        $client = static::createClient();
        $client->request('GET', $studentId);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            "@context" => "/contexts/Student",
            "@id" => $studentId,
            "@type" => "Student",
            "firstName" => "updatedFirstName",
            "lastName" => "TestLastName",
        ]);

        return $studentId;
    }

    /**
     * @depends testGetStudent
     */
    public function testDeleteStudent(string $studentId)
    {
        $client = static::createClient();

        $client->request('DELETE', $studentId);

        $this->assertResponseStatusCodeSame(204);

        $client->request('GET', $studentId);

        $this->assertResponseStatusCodeSame(404);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            "@context" => "/contexts/Error",
            "@type" => "hydra:Error",
            "hydra:title" => "An error occurred",
            "hydra:description" => "Not Found",
        ]);
    }

    public function testCreatInvalidStudent()
    {
        static::createClient()->request('POST', '/students', ['json' => [
            'firstName' => null,
            "lastName" => "TestLastName",
            "birthDay" => "2021-02-01T18:01:20+00:00"

        ]]);

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/contexts/Error',
            '@type' => 'hydra:Error',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'The type of the "firstName" attribute must be "string", "NULL" given.',
        ]);
    }

    public function testCreateInvalidStudentWithEmptyFirstName()
    {
        static::createClient()->request('POST', '/students', ['json' => [
            'firstName' => '',
            "lastName" => "TestLastName",
            "birthDay" => "2021-02-01T18:01:20+00:00"

        ]]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            "@context" => "/contexts/ConstraintViolationList",
            "@type" => "ConstraintViolationList",
            "hydra:title" => "An error occurred",
            "hydra:description" => "firstName: First name is required",
        ]);
    }
}
