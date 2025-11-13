<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourtScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'futsal_venue_id' => [
                'required',
                'integer',
                // Rule::exists('courts', 'id')->where(function ($query) {
                //     $query->where('futsal_venue_id', $this->user()->futsalVenue?->futsal_venue_id);
                // }),
            ],
            'court_id' => [
                'required',
                'integer',
                // Rule::exists('courts', 'id')->where(function ($query) {
                //     $query->where('futsal_venue_id', $this->user()->futsalVenue?->futsal_venue_id);
                // })
            ],
            'start_time' => 'sometimes|date_format:H:i',
            'end_time' => 'sometimes|date_format:H:i|after:start_time',
            'max_slots' => 'sometimes|integer|min:1',
            'recurring_days' => 'sometimes|array|min:1',
            'recurring_days.*' => 'string',
        ];
    }
}
