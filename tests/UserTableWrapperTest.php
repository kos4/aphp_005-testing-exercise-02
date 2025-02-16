<?php
require_once '../src/autoloader.php';

use Netology\UserTableWrapper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(UserTableWrapper::class)]
class UserTableWrapperTest extends TestCase
{
  public static function getProvider(): array
  {
    return [
      'test get' => [true],
    ];
  }

  #[DataProvider('getProvider')]
  public function testGet($expected): void
  {
    $userTableWrapper = new UserTableWrapper();
    $insertResult = $userTableWrapper->get();
    $this->assertEquals($expected, is_array($insertResult));
  }

  public static function insertProvider(): array
  {
    return [
      'test 1' => [
        [
          'id' => 1,
          'name' => 'Ivan',
        ],
        1,
      ],
      'test 2' => [
        [
          'id' => 2,
          'name' => 'Jon',
        ],
        1,
      ],
      'test 3' => [
        [
          'id' => 3,
          'name' => 'Alex',
        ],
        1,
      ],
    ];
  }

  #[DataProvider('insertProvider')]
  public function testInsert($array, $expected): void
  {
    $userTableWrapper = new UserTableWrapper();
    $userTableWrapper->insert($array);
    $insertResult = count($userTableWrapper->get());
    $this->assertEquals($expected, $insertResult);
  }

  public static function updateProvider(): array
  {
    return [
      'test success' => [
        [
          'id' => 1,
          'name' => 'Ivan',
        ],
        1,
        [
          'id' => 1,
          'name' => 'Jon',
        ],
        true,
      ],
      'test fail' => [
        [
          'id' => 1,
          'name' => 'Ivan',
        ],
        2,
        [
          'id' => 2,
          'name' => 'Jon',
        ],
        false,
      ],
    ];
  }

  #[DataProvider('updateProvider')]
  public function testUpdate($insArray, $id, $array, $expected): void
  {
    $userTableWrapper = new UserTableWrapper();
    $userTableWrapper->insert($insArray);
    $users = $userTableWrapper->update($id, $array);
    $this->assertEquals($expected, $users[$id] === $array);
  }

  public static function deleteProvider(): array
  {
    return [
      'test success' => [
        [
          [
            'id' => 1,
            'name' => 'Ivan',
          ],
          [
            'id' => 2,
            'name' => 'Jon',
          ],
        ],
        2,
        1,
      ],
      'test fail' => [
        [
          [
            'id' => 1,
            'name' => 'Ivan',
          ],
          [
            'id' => 2,
            'name' => 'Jon',
          ],
        ],
        3,
        2,
      ],
    ];
  }

  #[DataProvider('deleteProvider')]
  public function testDelete($insArray, $id, $expected): void
  {
    $userTableWrapper = new UserTableWrapper();
    foreach ($insArray as $array) {
      $userTableWrapper->insert($array);
    }
    $userTableWrapper->delete($id);
    $result = $userTableWrapper->get();
    $this->assertCount($expected, $result);
  }
}