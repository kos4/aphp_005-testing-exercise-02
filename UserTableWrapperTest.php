<?php
require_once 'autoloader.php';
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UserTableWrapper::class)]
class UserTableWrapperTest extends TestCase
{
  /**
   * @param $expected
   * @return void
   *
   * @dataProvider getProvider
   */
  public function testGet($expected): void
  {
    $userTableWrapper = new UserTableWrapper();
    $insertResult = $userTableWrapper->get();
    $this->assertEquals($expected, is_array($insertResult));
  }

  public function getProvider(): array
  {
    return [
      'test get' => [true],
    ];
  }

  /**
   * @param $array
   * @param $expected
   * @return void
   *
   * @dataProvider insertProvider
   */
  public function testInsert($array, $expected): void
  {
    $userTableWrapper = new UserTableWrapper();
    $userTableWrapper->insert($array);
    $insertResult = count($userTableWrapper->get());
    $this->assertEquals($expected, $insertResult);
  }

  public function insertProvider(): array
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

  /**
   * @param $insArray
   * @param $id
   * @param $array
   * @param $expected
   * @return void
   *
   * @dataProvider updateProvider
   */
  public function testUpdate($insArray, $id, $array, $expected): void
  {
    $userTableWrapper = new UserTableWrapper();
    $userTableWrapper->insert($insArray);
    $users = $userTableWrapper->update($id, $array);
    $this->assertEquals($expected, $users[$id] === $array);
  }

  public function updateProvider(): array
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

  /**
   * @param $insArray
   * @param $id
   * @param $expected
   * @return void
   *
   * @dataProvider deleteProvider
   */
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

  public function deleteProvider(): array
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
          ]
        ],
        2,
        1
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
          ]
        ],
        3,
        2
      ]
    ];
  }
}