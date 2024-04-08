<?php

namespace App\Factory;

use App\Entity\Birthday;
use App\Repository\BirthdayRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Birthday>
 *
 * @method static Birthday|Proxy createOne(array $attributes = [])
 * @method static Birthday[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Birthday[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Birthday|Proxy find(object|array|mixed $criteria)
 * @method static Birthday|Proxy findOrCreate(array $attributes)
 * @method static Birthday|Proxy first(string $sortedField = 'id')
 * @method static Birthday|Proxy last(string $sortedField = 'id')
 * @method static Birthday|Proxy random(array $attributes = [])
 * @method static Birthday|Proxy randomOrCreate(array $attributes = [])
 * @method static Birthday[]|Proxy[] all()
 * @method static Birthday[]|Proxy[] findBy(array $attributes)
 * @method static Birthday[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Birthday[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BirthdayRepository|RepositoryProxy repository()
 * @method Birthday|Proxy create(array|callable $attributes = [])
 */
final class BirthdayFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->text(),
            'birthday' => self::faker()->dateTime(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Birthday $birthday): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Birthday::class;
    }
}
