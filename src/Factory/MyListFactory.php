<?php

namespace App\Factory;

use App\Entity\MyList;
use App\Repository\MyListRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<MyList>
 *
 * @method        MyList|Proxy create(array|callable $attributes = [])
 * @method static MyList|Proxy createOne(array $attributes = [])
 * @method static MyList|Proxy find(object|array|mixed $criteria)
 * @method static MyList|Proxy findOrCreate(array $attributes)
 * @method static MyList|Proxy first(string $sortedField = 'id')
 * @method static MyList|Proxy last(string $sortedField = 'id')
 * @method static MyList|Proxy random(array $attributes = [])
 * @method static MyList|Proxy randomOrCreate(array $attributes = [])
 * @method static MyListRepository|RepositoryProxy repository()
 * @method static MyList[]|Proxy[] all()
 * @method static MyList[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static MyList[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static MyList[]|Proxy[] findBy(array $attributes)
 * @method static MyList[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static MyList[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class MyListFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'genre' => self::faker()->randomElement(['komedie', 'drama', 'akční']),
            'movieCount' => self::faker()->randomNumber(1,50),
            'rating' => self::faker()->randomNumber(1,10),
            'slug' => self::faker()->text(100),
            'title' => self::faker()->words(3, true),
            'description' => self::faker()->paragraph()
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(MyList $myList): void {})
        ;
    }

    protected static function getClass(): string
    {
        return MyList::class;
    }
}
