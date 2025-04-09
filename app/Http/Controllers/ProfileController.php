<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $newCountryCode = $this->getDialingCode($validated['country']);

        // Clean all known country codes from beginning of phone
        $dialCodes = $this->getAllDialingCodes();
        $cleanPhone = $validated['phone'];
        foreach ($dialCodes as $code) {
            $cleanPhone = preg_replace('/^\+?' . preg_quote($code) . '/', '', $cleanPhone);
        }

        // Save phone with new country prefix
        $validated['phone'] = '+' . $newCountryCode . $cleanPhone;

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'passport_number' => $validated['passport_number'],
            'country' => $validated['country'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    private function getAllDialingCodes(): array
    {
        return [
            'RS' => '381', 'US' => '1', 'AF' => '93', 'AL' => '355', 'DZ' => '213',
            'AS' => '1684', 'AD' => '376', 'AO' => '244', 'AI' => '1264', 'AQ' => '672',
            'AG' => '1268', 'AR' => '54', 'AM' => '374', 'AW' => '297', 'AU' => '61',
            'AT' => '43', 'AZ' => '994', 'BS' => '1242', 'BH' => '973', 'BD' => '880',
            'BB' => '1246', 'BY' => '375', 'BE' => '32', 'BZ' => '501', 'BJ' => '229',
            'BM' => '1441', 'BT' => '975', 'BO' => '591', 'BA' => '387', 'BW' => '267',
            'BR' => '55', 'BN' => '673', 'BG' => '359', 'BF' => '226', 'BI' => '257',
            'KH' => '855', 'CM' => '237', 'CA' => '1', 'CV' => '238', 'CF' => '236',
            'TD' => '235', 'CL' => '56', 'CN' => '86', 'CO' => '57', 'KM' => '269',
            'CD' => '243', 'CG' => '242', 'CR' => '506', 'HR' => '385', 'CU' => '53',
            'CY' => '357', 'CZ' => '420', 'DK' => '45', 'DJ' => '253', 'DM' => '1767',
            'DO' => '1809', 'EC' => '593', 'EG' => '20', 'SV' => '503', 'GQ' => '240',
            'ER' => '291', 'EE' => '372', 'SZ' => '268', 'ET' => '251', 'FJ' => '679',
            'FI' => '358', 'FR' => '33', 'GA' => '241', 'GM' => '220', 'GE' => '995',
            'DE' => '49', 'GH' => '233', 'GR' => '30', 'GD' => '1473', 'GT' => '502',
            'GN' => '224', 'GW' => '245', 'GY' => '592', 'HT' => '509', 'HN' => '504',
            'HK' => '852', 'HU' => '36', 'IS' => '354', 'IN' => '91', 'ID' => '62',
            'IR' => '98', 'IQ' => '964', 'IE' => '353', 'IL' => '972', 'IT' => '39',
            'JM' => '1876', 'JP' => '81', 'JO' => '962', 'KZ' => '7', 'KE' => '254',
            'KI' => '686'
        ];
    }

    private function getDialingCode(string $countryCode): string
    {
        $dialCodes = $this->getAllDialingCodes();
        return $dialCodes[$countryCode] ?? '';
    }



}
