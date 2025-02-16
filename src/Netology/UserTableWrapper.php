<?php
namespace Netology;

use Netology\Interfaces\TableWrapperInterface;

class UserTableWrapper implements TableWrapperInterface
{
  private array $rows = [];

  /**
   * @param array|[column => row_value] $values
   */
  public function insert(array $values): void
  {
    $this->rows[$values['id']] = $values;
  }

  public function update(int $id, array $values): array
  {
    if (array_key_exists($id, $this->rows)) {
      $this->rows[$id] = $values;
    }

    return $this->rows;
  }

  public function delete(int $id): void
  {
    if (array_key_exists($id, $this->rows)) {
      unset($this->rows[$id]);
    }
  }

  public function get(): array
  {
    return $this->rows;
  }
}