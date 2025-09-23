<?php

namespace App\DTOs;

use App\Enums\ReportReason;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ReportsDTO
{
    public function __construct(
      public readonly int $userId,
      public readonly ReportReason $reason,
      public readonly ?string $other = null

    ){}
     public static function fromRequest(Request $request): self
    {
        $validated = $request->validate([
            'report_reason' => ['required', new Enum(ReportReason::class)],
            'other' => [
                 'nullable',
                 'string',
                 'required_if:report_reason,' . ReportReason::Other->value
                ],
        ]);

        return new self(
            userId: auth()->id(),
            reason: ReportReason::from($validated['report_reason']),
            other: $validated['report_reason'] === ReportReason::Other->value ? $validated['other'] : null
        );
    }
}
