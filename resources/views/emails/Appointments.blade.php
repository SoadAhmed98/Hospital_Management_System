@component('mail::message')
<table style="width: 100%; font-family: Arial, sans-serif; border-collapse: collapse;">
    <tr>
        <td style="padding: 20px; background-color: #f8f9fa; text-align: center;">
            <h1 style="font-size: 24px; color: #333;">Dear {{ $name }},</h1>
            <p style="font-size: 16px; color: #555;">Your appointment has been booked on:</p>
            <p style="font-size: 18px; color: #000; font-weight: bold;">{{ $appointment }}</p>
            <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
            <p style="font-size: 16px; color: #555;">Thank you for choosing our services. We look forward to seeing you.</p>
            <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
            <p style="font-size: 16px; color: #555;">If you have any questions or need to reschedule, please do not hesitate to contact us.</p>
            <p style="font-size: 16px; color: #555;">Thanks,<br>{{ config('app.name') }}</p>
        </td>
    </tr>
   
</table>
@endcomponent
