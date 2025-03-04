<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Native\Laravel\Facades\Notification;
use Symfony\Component\HttpFoundation\Response as Code;

trait ResponseTrait
{
    /**
     * @param string|null $message
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(?string $message = '', mixed $data = [], int $code = Code::HTTP_OK): JsonResponse
    {
        if (!empty($message)) {
            $this->nativeAlertNotify('Təbriklər!', $message);
        }
        return response()->json(["message" => $message, "result" => $data], $code);
    }

    /**
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse(?string $message = '', mixed $data = [], int $code = Code::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        if (!empty($message)) {
            $this->nativeAlertNotify('Səhv!', $message);
        }
        return response()->json(["message" => $message, "result" => $data], $code);
    }

    /**
     * @param string $title
     * @param string $message
     * @return void
     */
    public function nativeAlertNotify(string $title, string $message): void
    {
        Notification::title($title)
            ->message($message)
            ->show();
    }
}
