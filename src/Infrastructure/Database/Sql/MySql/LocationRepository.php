<?php /** @noinspection DuplicatedCode */

namespace Fira\Infrastructure\Database\Sql\Mysql;

use DateTimeImmutable;
use Fira\App\DependencyContainer;
use Fira\Domain\Entity\Entity;
use Fira\Domain\Entity\LocationEntity;
use Fira\Domain\Utility\Pager;
use Fira\Domain\Utility\Sort;

class LocationRepository implements \Fira\Domain\Repository\LocationRepository
{
    private string $name;
    private int $page;
    private int $row;
    private int $entity;
    private array $entity1;
    private int $repo;
    private  $locationRepository;

    public function __constructor(int $page , int $rows){
       $this-> page +=1;
       $this-> row += 1;
    }
    public function getByName(string $name, Pager $pager, Sort $sort): array
    {
        $rowData = DependencyContainer::getSqlDriver()->getRowByName($name, 'locations');
        $entity = new LocationEntity();
        $entity
            ->setId($rowData['id'])
            ->setName($rowData['name'])
            ->setCategory($rowData['category'])
            ->setDescription($rowData['description'])
            ->setLatitude($rowData['latitude'])
            ->setLongitude($rowData['longitude'])
            ->setCreatedAt(new DateTimeImmutable($rowData['created_at']));
        $entity1 = sort($entity);
        return array($entity1);
    }

    public function getByCategory(string $category, Pager $pager, Sort $sort): array
    {
        $rowData = DependencyContainer::getSqlDriver()->getRowByName($category, 'locations');
        $entity = new LocationEntity();
        $entity
            ->setId($rowData['id'])
            ->setName($rowData['name'])
            ->setCategory($rowData['category'])
            ->setDescription($rowData['description'])
            ->setLatitude($rowData['latitude'])
            ->setLongitude($rowData['longitude'])
            ->setCreatedAt(new DateTimeImmutable($rowData['created_at']));
        $entity1 = sort($entity);
        return array($entity1);

    }

    public function registerEntity(Entity $entity, $register): void
    {
        $rowData = DependencyContainer::getSqlDriver()->getBycategory($register, 'locations');
        $entity = new LocationEntity();
        $entity
            ->setId($rowData['id'])
            ->setName($rowData['name'])
            ->setCategory($rowData['category'])
            ->setDescription($rowData['description'])
            ->setLatitude($rowData['latitude'])
            ->setLongitude($rowData['longitude'])
            ->setCreatedAt(new DateTimeImmutable($rowData['created_at']));
        $entity1 = sort($entity);
       return array($entity);
    }

    public function save(): void
    {
        $this->validate();
        $locationEntity = new LocationEntity();
        $locationEntity
            ->setName($this->name)
            ->setCategory($this->category)
            ->setDescription($this->description)
            ->setLongitude($this->longitude)
            ->setLatitude($this->latitude);

        $this->repository->registerEntity($locationEntity);
        $this->repository->save();

        return $locationEntity;
    }

    public function getById(int $id): Entity
    {
        $rowData = DependencyContainer::getSqlDriver()->getRowById($id, 'locations');
        return $this->loadEntityData($rowData);
    }

    public function getByIds(array $id): array
    {
        $rowData = DependencyContainer::getSqlDriver()->getByid($id, 'locations');
        $entity = new LocationEntity();
        $entity
            ->setId($rowData['id'])
            ->setName($rowData['name'])
            ->setCategory($rowData['category'])
            ->setDescription($rowData['description'])
            ->setLatitude($rowData['latitude'])
            ->setLongitude($rowData['longitude'])
            ->setCreatedAt(new DateTimeImmutable($rowData['created_at']));
        $entity1 = sort($entity);
        return array($entity1);
    }

    public function delete(int $id): void
    {
        $this->entity = $id;
        $this->repo = $id;
    }

    public function getNextid(): int
    {
        $id = 0;
        foreach($this->entity1 as $entity){
            if (!empty($entity)) {
                if($entity->getId() = $id){
                $id = $entity->getId();
            }
            }
        }
        return ++$id;
    }

    public function search(array $searchParams, Pager $pager, Sort $sort): array
    {
        $name = $searchParams['name'] ?? null;
        $category = $searchParams['category'] ?? null;
        $where = '';
        if ($name) {
            $where = "name = {$name}";
        }

        if ($category) {
            $where = "category = {$category}";
        }

        $results = [];
        $items = DependencyContainer::getSqlDriver()->select(['*'], 'location', $where);

        foreach ($items as $item) {
            // Item => entity
            $results[] = $this->loadEntityData($item);
        }

        return $results;
    }

    private function loadEntityData(array $rowData): LocationEntity
    {
        $entity = new LocationEntity();
        $entity
            ->setId($rowData['id'])
            ->setName($rowData['name'])
            ->setCategory($rowData['category'])
            ->setDescription($rowData['description'])
            ->setLatitude($rowData['latitude'])
            ->setLongitude($rowData['longitude'])
            ->setCreatedAt(new DateTimeImmutable($rowData['created_at']));

        return $entity;
    }
}
