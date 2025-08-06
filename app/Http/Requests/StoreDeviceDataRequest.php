<?php
// app/Http/Requests/StoreDeviceDataRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceDataRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'device_id' => 'required|exists:devices,id',
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'status' => 'required|string',
            'event_timestamp' => 'required|date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
