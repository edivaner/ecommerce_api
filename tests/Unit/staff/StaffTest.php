<?php
namespace Tests\Unit\staff;

use App\Http\Controllers\AuthController;
use Tests\TestCase;
use App\Repositories\Staff\StaffRepositoryInterface;
use App\Services\StaffService;
use App\Http\Controllers\StaffController;
use Illuminate\Http\Request as HttpRequest;
use App\Providers\AppServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class StaffTest extends TestCase
{
    use RefreshDatabase;
    
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function loginAdmin()
    {
        $responseLogin = $this->app->make(AuthController::class)->login(new HttpRequest(
            [
                "email" => "edi0@order.com",
                "password" => "4321"
            ]
        ));

        return $responseLogin;
    }

    public function test_StoreStaff()
    {
        $instanciaLogin = $this->loginAdmin();
        $tokenLogin = json_decode($instanciaLogin->getContent())->access_token;

        $user = [
            "user" => [
                "name" => "Marcinho VP",
                "email" => "cv@order.com",	
                "password" => "4321"
            ]
        ];
        $address = [
            "address" => [
                "street" => "Curva do S",
                "neighborhood" => "Rocinha",
                "number" => "07",
                "city" => "Rio de Janeiro",
                "reference" => "n/a"
            ]
        ];
        $staff = array_merge(
            $user, 
            $address,             
            ["telephone" => "3288888888"]
        );

        $retorno = $this->withHeaders([
            'Authorization' => "Bearer $tokenLogin", // Define o token no cabeçalho
        ])->postJson('/api/staff', $staff);

        $retorno->assertJson([
            "message" => "Funcionário cadastrado com sucesso"
        ]);

        // $this->assertDatabaseHas('users', [
        //     'name' => 'edivaner Fernandes',
        //     'email' => 'edi@order.com',
        //     'role' => 'admin'
        // ]);

        // $this->assertDatabaseHas('addresses', $address);

        // $this->assertDatabaseHas('staffs', [
        //     'telephone' => '329999999'
        // ]);

        $this->tearDown();
    }
}
?>