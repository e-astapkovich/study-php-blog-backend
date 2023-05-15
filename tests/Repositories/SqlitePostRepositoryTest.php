<?php

namespace Eastap\PhpBlog\UnitTests\Repositories;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Eastap\PhpBlog\Blog\Post;
use Eastap\PhpBlog\Repositories\SqlitePostRepository;
use Eastap\PhpBlog\UUID;

final class SqlitePostRepositoryTest extends TestCase
{
    private function createPostRepository()
    {
        $connectionStab = $this->createStub(PDO::class);
        $statementMock = $this->createMock(PDOStatement::class);
        $statementMock
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid' => '123e4567-e89b-12d3-a456-426614174000',
                ':author_uuid' => '3bed1a29-6737-45ff-81f2-7366f56498a7',
                ':title' => 'title',
                ':text' => 'test text'
            ]);
        $connectionStab->method('prepare')->willReturn($statementMock);

        return new SqlitePostRepository($connectionStab);
    }

    public function testItSavePostToDb()
    {
        $repository = $this->createPostRepository();
        $repository->save(new Post(
            new UUID('123e4567-e89b-12d3-a456-426614174000'),
            new UUID('3bed1a29-6737-45ff-81f2-7366f56498a7'),
            'title',
            'test text'
        ));
    }
}
