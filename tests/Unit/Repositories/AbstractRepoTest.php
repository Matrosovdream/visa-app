<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Geo\CountryRepo;
use App\Repositories\User\UserRepo;
use App\Repositories\User\RoleRepo;
use App\Repositories\Content\ArticleRepo;
use App\Repositories\Product\ProductRepo;
use App\Repositories\Order\OrderRepo;
use App\Repositories\Order\OrderStatusRepo;
use App\Repositories\Payment\PaymentGatewayRepo;
use App\Repositories\Geo\TravelDirectionRepo;
use App\Repositories\Geo\LanguageRepo;
use App\Repositories\Geo\CurrencyRepo;
use App\Repositories\Content\SiteSettingsRepo;
use App\Repositories\Content\FileRepo;
use App\Repositories\Content\ReviewRepo;
use App\Repositories\Cart\CartRepo;
use App\Repositories\Traveller\TravellerRepo;
use App\Repositories\Product\ProductOffersRepo;
use App\Repositories\Product\ProductExtrasRepo;

class AbstractRepoTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_repos_can_be_instantiated(): void
    {
        $repos = [
            CountryRepo::class,
            UserRepo::class,
            RoleRepo::class,
            ArticleRepo::class,
            ProductRepo::class,
            OrderRepo::class,
            OrderStatusRepo::class,
            PaymentGatewayRepo::class,
            TravelDirectionRepo::class,
            LanguageRepo::class,
            CurrencyRepo::class,
            SiteSettingsRepo::class,
            FileRepo::class,
            ReviewRepo::class,
            CartRepo::class,
            TravellerRepo::class,
            ProductOffersRepo::class,
            ProductExtrasRepo::class,
        ];

        foreach ($repos as $repoClass) {
            $repo = new $repoClass();
            $this->assertNotNull($repo->getModel(), "$repoClass should have a model set");
        }
    }

    public function test_repo_getall_returns_expected_structure(): void
    {
        $repo = new CountryRepo();
        $result = $repo->getAll([], 10);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('items', $result);
        $this->assertArrayHasKey('Model', $result);
    }

    public function test_repo_getbyid_returns_null_for_nonexistent(): void
    {
        $repo = new CountryRepo();
        $result = $repo->getByID(99999);

        $this->assertNull($result);
    }

    public function test_repo_count_returns_integer(): void
    {
        $repo = new CountryRepo();
        $count = $repo->count();

        $this->assertIsInt($count);
    }

    public function test_repo_exists_returns_boolean(): void
    {
        $repo = new CountryRepo();
        $exists = $repo->exists(['id' => 99999]);

        $this->assertFalse($exists);
    }

    public function test_repo_set_relations(): void
    {
        $repo = new CountryRepo();
        $result = $repo->setRelations(['products']);

        $this->assertSame($repo, $result);
    }
}
