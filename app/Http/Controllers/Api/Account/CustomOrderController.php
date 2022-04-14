<?php

namespace App\Http\Controllers\Api\Account;

use App\Command\Order\CustomOrder\Create\CustomOrderCommand;
use App\Command\Order\CustomOrder\Create\CustomOrderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CustomOrderRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CustomOrderController extends Controller
{
    private $denormalizer;
    private $handler;

    public function __construct(
        DenormalizerInterface $denormalizer,
        CustomOrderHandler $handler
    ) {
        parent::__construct();

        $this->middleware('auth:api');

        $this->denormalizer = $denormalizer;
        $this->handler = $handler;
    }

    /**
     * @OA\Post(
     *     path="/api/orders/custom",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/CustomOrderCreate")
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=401, description="Not authorize"),
     *     @OA\Response(response=422, description="Unprocessable entity")
     * )
     */
    public function index(CustomOrderRequest $request)
    {
        /** @var CustomOrderCommand $command */
        $command = $this->denormalizer->denormalize($request->all(), CustomOrderCommand::class);
        $command->userId = $request->user()->id;

        $this->handler->handle($command);

        return new JsonResponse(['status' => 'Ok'], 201);
    }
}
