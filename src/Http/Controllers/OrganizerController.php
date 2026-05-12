<?php

namespace ArcdevPackages\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use ArcdevPackages\Core\Helpers\Encrypt;
use ArcdevPackages\Core\Helpers\HashHelper;
use ArcdevPackages\Core\Models\Organizer;
use ArcdevPackages\Core\Traits\UtilsTrait;

class OrganizerController extends Controller
{
    use UtilsTrait;
    use ValidatesRequests;

    private const PAYMENT_METHOD_ENUM_CLASS = 'App\\Enums\\PaymentMethod';

    private const QR_PAYMENT_METHOD_CONFIG_KEYS = [
        1 => 'show_credit_debit',
        2 => 'show_e_wallet',
        3 => 'show_others',
        4 => 'show_others',
        7 => 'show_gcash',
        8 => 'show_food_panda',
        9 => 'show_grab',
        10 => 'show_maya',
        11 => 'show_bpi',
        12 => 'show_bdo',
        13 => 'show_gotyme',
        14 => 'show_unionbank',
        15 => 'show_maribank',
    ];

    private const PAYMENT_METHOD_FALLBACK_LABELS = [
        1 => 'Credit/Debit Card',
        2 => 'E-Wallet',
        3 => 'Bank Transfer',
        4 => 'Online Payment Gateways',
        7 => 'GCash',
        8 => 'Food Panda',
        9 => 'Grab',
        10 => 'Maya',
        11 => 'BPI',
        12 => 'BDO',
        13 => 'GoTyme',
        14 => 'UnionBank',
        15 => 'MariBank',
    ];

    public function index()
    {
        if ( !Auth::user()->super_admin ) {
            return Inertia::render('Unauthorized');
        }
        
        return Inertia::render('Organizers/Index');
    }

    public function organizerProfile()
    {
        $organizer = Organizer::find(Auth::user()->organizer_id);

        if ( !empty($organizer) ) {
            return Inertia::render('Organizers/AddEdit', [
                'from_profile' => true,
                'organizer_id' => $organizer->hashid,
                'action' => 'Edit',
            ]);
        }

        return Inertia::render('Unauthorized');
    }
    
    public function getOrganizerList()
    {
        $organizersList = Organizer::select('id', 'id as value', 'business_name as label')
            ->active()
            ->orderBy('business_name')
            ->get();

        foreach ( $organizersList as $organizer ) {
            $organizer->value = $organizer->hashid;
            unset($organizer->hashid);
        }

        return response()->json(Encrypt::encryptData($organizersList));
    }

    public function getAll(Request $request)
    {
        $page = 1;
        $itemsPerPage = 20;
        $offset = 0;
        $total = 0;
        $sortBy = 'business_name';
        $sortDesc = 'ASC';
        $search = '';
        $filters = null;

        if ( !empty($request->page) ) {
            $page = $request->page;
        }

        if ( !empty($request->itemsPerPage) ) {
            $itemsPerPage = $request->itemsPerPage;
        }

        if ( !empty($request->page) && !empty($request->itemsPerPage) ) {
            if ( $request->itemsPerPage != -1 ) {
                $offset = ($page - 1) * $itemsPerPage;
            }
        }

        if ( !empty($request->search) ) {
            $search = $request->search;
        }

        if ( !empty($request->sortBy) ) {
            $sortBy = $request->sortBy;
        }

        if ( !empty($request->sortDesc) ) {
            $sortDesc = $request->sortDesc;
        }

        if ( !empty($request->filters) ) {
            $filters = json_decode($request->filters);
        }

        $org_ids = [];

        if ( !Auth::user()->super_admin ) {
            $org_ids[] = Auth::user()->organizer_id;
        }

        $organizerTable = (new Organizer())->getTable();

        $columns = [
            'id',
            'business_name',
            'first_name',
            'last_name',
            'domain_name',
            'slug',
            'thumbnail_url',
            'profile_thumb_url',
            'organizer_type',
            'active',
        ];

        if ( Schema::hasColumn($organizerTable, 'venue_id') ) {
            $columns[] = 'venue_id';
        }

        if ( Schema::hasColumn($organizerTable, 'waiver') ) {
            $columns[] = 'waiver';
        }

        if ( Schema::hasColumn($organizerTable, 'payment_qr_codes') ) {
            $columns[] = 'payment_qr_codes';
        }

        $organizers = Organizer::select($columns)
            ->when(!empty($org_ids), function ( $query ) use ( $org_ids ) {
                return $query->whereIn('id', $org_ids);
            });

        if ( isset($filters->active) ) {
            $organizers->where('organizers.active', $filters->active);
        }

        if ( !empty($search) ) {
            $organizers = $organizers->where(function ( $query ) use ( $search ) {
                $query->where('organizers.business_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('organizers.first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('organizers.last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere(DB::raw('CONCAT(first_name," ",last_name)'), 'LIKE', '%' . $search . '%')
                    ->orWhere(DB::raw('CONCAT(last_name," ",first_name)'), 'LIKE', '%' . $search . '%');
            });
        }

        $total = $organizers->count();

        if ( $itemsPerPage != -1 ) {
            $organizers = $organizers->offset($offset)->limit($itemsPerPage);
        }

        if ( $sortBy == 'type_text' ) {
            $sortBy = 'organizer_type';
        }

        $organizers = $organizers->orderBy('organizers.' . $sortBy, $sortDesc)->get();

        return response()->json([
            'status' => 200,
            'data' => Encrypt::encryptData($organizers),
            'total' => $total,
        ]);
    }

    public function show($hashid)
    {
        $id = HashHelper::decodeId($hashid);
        $organizer = Organizer::find($id);
        
        if ( !empty($organizer) ) {
            if ( !empty($organizer->social_media_data) ) {
                $social_media_list = config('dropdown.social_media_list');

                $socmeds = json_decode($organizer->social_media_data);

                foreach ( $socmeds as $key => $socmed ) {
                    $socmed->type_text = isset($social_media_list[$socmed->type]) ? $social_media_list[$socmed->type] : '';
                }

                $organizer->social_media_data = json_encode($socmeds);
            }

            if ( Schema::hasColumn($organizer->getTable(), 'payment_qr_codes') ) {
                $organizer->payment_qr_codes = $this->normalizePaymentQrCodes($organizer);
                $organizer->payment_method_options = $this->paymentMethodOptions($organizer);
            }
        }

        return response()->json(Encrypt::encryptData($organizer));
    }

    public function create()
    {
        return Inertia::render('Organizers/AddEdit', [
            'action' => 'Add',
        ]);
    }

    public function mapModel($organizer, $input)
    {
        $business_name = '';

        if ( $input['organizer_type'] == 1 ) {
            if ( !empty($input['first_name']) ) {
                $business_name = $input['first_name'];
            }

            if ( !empty($input['middle_name']) ) {
                $business_name .= ' ' . Str::upper(substr($input['middle_name'], 0, 1)) . '.';
            }

            if ( !empty($input['last_name']) ) {
                $business_name .= ' ' . $input['last_name'];
            }

            $organizer->business_name = $this->clearChars($business_name);
        } else {
            $organizer->business_name = isset($input['business_name']) ? $this->clearChars($input['business_name']) : null;
        }

        $organizer->first_name = $this->clearChars($input['first_name']);
        $organizer->last_name = $this->clearChars($input['last_name']);
        $organizer->middle_name = isset($input['middle_name']) ? $this->clearChars($input['middle_name']) : null;
        $organizer->domain_name = isset($input['domain_name']) ? $input['domain_name'] : null;
        $organizer->email = isset($input['email']) ? $input['email'] : null;
        $organizer->mobile_no = isset($input['mobile_no']) ? $this->clearChars($input['mobile_no']) : null;
        $organizer->mobile_no_2 = isset($input['mobile_no_2']) ? $this->clearChars($input['mobile_no_2']) : null;
        $organizer->business_address = isset($input['business_address']) ? $this->clearChars($input['business_address']) : null;
        $organizer->social_media_data = isset($input['social_media_data']) ? $input['social_media_data'] : null;
        $organizer->active = (isset($input['active']) && $input['active'] == 1) ? 1 : 0;
        $organizer->organizer_type = (isset($input['organizer_type']) && $input['organizer_type'] == 1) ? 1 : 0;
        $organizer->remarks = isset($input['remarks']) ? $this->clearChars($input['remarks']) : '';
        $organizer->slug = isset($input['slug']) ? $this->clearChars($input['slug']) : null;

        if ( Schema::hasColumn($organizer->getTable(), 'waiver') ) {
            $organizer->waiver = isset($input['waiver']) && trim((string) $input['waiver']) !== ''
                ? trim((string) $input['waiver'])
                : null;
        }

        if ( Schema::hasColumn($organizer->getTable(), 'venue_id') && array_key_exists('venue_id', $input) ) {
            $organizer->venue_id = !empty($input['venue_id'])
                ? (is_numeric($input['venue_id']) ? (int) $input['venue_id'] : decodeId($input['venue_id']))
                : null;
        }
       
        return $organizer;
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $organizer = new Organizer();

        $this->validate($request, $organizer->rules, $organizer->messages);

        $organizer = $this->mapModel($organizer, $input);
        $this->unsetComputedOrganizerAttributes($organizer);

        $organizer->save();

        if ( $organizer && $request->hasFile('image_url') ) {
            $organizer->uploadImageUrl($request);
        }

        if ( $organizer && $request->hasFile('profile_url') ) {
            $organizer->uploadProfileUrl($request);
        }

        return response()->json($organizer);
    }

    public function edit($id)
    {
        return Inertia::render('Organizers/AddEdit', [
            'organizer_id' => $id,
            'action' => 'Edit',
        ]);
    }

    public function update(Request $request, $hashid)
    {
        $id = HashHelper::decodeId($hashid);
        $input = $request->all();

        $organizer = Organizer::findOrFail($id);
        $organizer->rules['business_name'] = 'required_if:organizer_type,0|max:200|unique:organizers,business_name,' . $id . ',id';

        $this->validate($request, $organizer->rules, $organizer->messages);

        $organizer = $this->mapModel($organizer, $input);
        $this->unsetComputedOrganizerAttributes($organizer);
        $organizer->update();
      
        if ( !empty($request->delete_image_url) ) {
            $organizer->deleteImage($organizer->image_url, $organizer->thumbnail_url);
            $organizer->image_url = null;
            $organizer->thumbnail_url = null;
            $this->unsetComputedOrganizerAttributes($organizer);
            $organizer->update();
        } else {
            if ( $organizer && $request->hasFile('image_url') ) {
                $organizer->uploadImageUrl($request);
            }
        }

        if ( !empty($request->delete_profile_url) ) {
            $organizer->deleteImage($organizer->profile_url, $organizer->profile_thumb_url);
            $organizer->profile_url = null;
            $organizer->profile_thumb_url = null;
            $this->unsetComputedOrganizerAttributes($organizer);
            $organizer->update();
        } else {
            if ( $organizer && $request->hasFile('profile_url') ) {
                $organizer->uploadProfileUrl($request);
            }
        }

        return response()->json($organizer);
    }

    public function updatePaymentQrCodes(Request $request, $hashid)
    {
        $id = is_numeric($hashid) ? (int) $hashid : HashHelper::decodeId($hashid);
        $organizer = Organizer::find($id);

        if ( empty($organizer) ) {
            return response()->json([
                'errors' => [ 'organizer' => [ 'Organizer not found.' ] ],
            ], 422);
        }

        if ( !Schema::hasColumn($organizer->getTable(), 'payment_qr_codes') ) {
            return response()->json([
                'errors' => [ 'payment_qr_codes' => [ 'The payment QR codes column is not available.' ] ],
            ], 422);
        }

        $request->validate([
            'payment_qr_code_files.*' => [ 'nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096' ],
        ]);

        $rows = $request->input('payment_qr_codes', []);

        if ( is_string($rows) ) {
            $rows = json_decode($rows, true);
        }

        if ( !is_array($rows) ) {
            $rows = [];
        }

        $errors = [];
        $availablePaymentMethodValues = collect($this->paymentMethodOptions($organizer))
            ->pluck('value')
            ->map(function ( $value ) {
                return (int) $value;
            })
            ->values()
            ->all();

        foreach ( $rows as $index => $row ) {
            $paymentMethod = (int) ($row['payment_method'] ?? -1);
            $hasExistingQrCode = !empty($row['qr_code_url']) && empty($row['delete_qr_code_url']);
            $hasNewQrCode = $request->hasFile('payment_qr_code_files.' . $index);

            if ( $paymentMethod < 0 ) {
                $errors['payment_qr_codes.' . $index . '.payment_method'][] = 'Please select a payment method.';
                continue;
            }

            if ( !in_array($paymentMethod, $availablePaymentMethodValues, true) ) {
                $errors['payment_qr_codes.' . $index . '.payment_method'][] = 'This payment method is disabled in the organizer config.';
            }

            if ( !$hasExistingQrCode && !$hasNewQrCode ) {
                $errors['payment_qr_code_files.' . $index][] = 'Please upload a QR code image.';
            }
        }

        if ( !empty($errors) ) {
            return response()->json([
                'errors' => $errors,
            ], 422);
        }

        $oldRows = $this->normalizePaymentQrCodes($organizer);
        $oldRowsByPaymentMethod = collect($oldRows)
            ->keyBy('payment_method')
            ->all();

        $cleanRows = [];

        foreach ( $rows as $index => $row ) {
            $paymentMethod = (int) ($row['payment_method'] ?? -1);

            if ( $paymentMethod < 0 ) {
                continue;
            }

            $oldRow = $oldRowsByPaymentMethod[$paymentMethod] ?? [];
            $qrCodeUrl = trim((string) ($row['qr_code_url'] ?? $oldRow['qr_code_url'] ?? ''));

            if ( !empty($row['delete_qr_code_url']) && $qrCodeUrl !== '' ) {
                $this->deletePublicStorageUrl($qrCodeUrl);
                $qrCodeUrl = '';
            }

            if ( $request->hasFile('payment_qr_code_files.' . $index) ) {
                if ( $qrCodeUrl !== '' ) {
                    $this->deletePublicStorageUrl($qrCodeUrl);
                }

                $qrCodeUrl = $this->storePaymentQrCodeFile(
                    $request->file('payment_qr_code_files.' . $index),
                    (int) $organizer->id,
                    $paymentMethod
                );
            }

            if ( $qrCodeUrl === '' ) {
                continue;
            }

            $cleanRows[] = [
                'payment_method' => $paymentMethod,
                'payment_method_label' => $this->paymentMethodLabel($paymentMethod),
                'account_name' => trim((string) ($row['account_name'] ?? '')),
                'account_number' => trim((string) ($row['account_number'] ?? '')),
                'qr_code_url' => $qrCodeUrl,
                'remarks' => trim((string) ($row['remarks'] ?? '')),
            ];
        }

        $newPaymentMethods = collect($cleanRows)
            ->pluck('payment_method')
            ->all();

        foreach ( $oldRows as $oldRow ) {
            $oldPaymentMethod = (int) ($oldRow['payment_method'] ?? -1);

            if (
                $oldPaymentMethod >= 0
                && !in_array($oldPaymentMethod, $newPaymentMethods, true)
                && !empty($oldRow['qr_code_url'])
            ) {
                $this->deletePublicStorageUrl((string) $oldRow['qr_code_url']);
            }
        }

        $organizer->payment_qr_codes = $cleanRows;
        $this->unsetComputedOrganizerAttributes($organizer);
        $organizer->save();

        return response()->json([
            'payment_qr_codes' => $cleanRows,
            'payment_method_options' => $this->paymentMethodOptions($organizer),
        ]);
    }

    public function destroy($hashid)
    {
        $id = HashHelper::decodeId($hashid);
        $data['error'] = '';
        $organizer = Organizer::find($id);

        if ( empty($organizer) ) {
            $data['error'] .= 'Cannot find Organizer';

            return json_encode($data);
        }

        $products_count = 0;

        if ( $products_count > 0 ) {
            $data['error'] .= 'Cannot delete, This Organizer is used in games';

            return json_encode($data);
        }

        $organizer->deleteImage($organizer->image_url, $organizer->thumbnail_url);
        $organizer->deleteImage($organizer->profile_url, $organizer->profile_thumb_url);
        $organizer->forceDelete();

        return response()->json('Delete Organizer Successful!');
    }

    public function getOrganizerLogo()
    {
        $currentDomain = request()->getHost();

        if ( $currentDomain == 'arcdevbuilder' ) {
            if ( Auth::check() ) {
                $organizer = Organizer::select('image_url', 'thumbnail_url')
                    ->where('id', Auth::user()->organizer_id)
                    ->first();
            } else {
                $organizer = Organizer::select('image_url', 'thumbnail_url')->first();
            }
        } else {
            $organizer = Organizer::select('image_url', 'thumbnail_url')
                ->where('domain_name', $currentDomain)
                ->first();
        }

        if ( !empty($organizer) ) {
            return response()->json($organizer);
        }

        return response()->json([
            'logo' => 1,
        ]);
    }

    private function normalizePaymentQrCodes(Organizer $organizer): array
    {
        $rows = $organizer->payment_qr_codes ?? [];

        if ( is_string($rows) ) {
            $rows = json_decode($rows, true);
        }

        if ( !is_array($rows) ) {
            return [];
        }

        return collect($rows)
            ->filter(function ( $row ) {
                return is_array($row) && isset($row['payment_method']) && !empty($row['qr_code_url']);
            })
            ->map(function ( array $row ) {
                $paymentMethod = (int) $row['payment_method'];

                return [
                    'payment_method' => $paymentMethod,
                    'payment_method_label' => $this->paymentMethodLabel($paymentMethod),
                    'account_name' => trim((string) ($row['account_name'] ?? '')),
                    'account_number' => trim((string) ($row['account_number'] ?? '')),
                    'qr_code_url' => trim((string) ($row['qr_code_url'] ?? '')),
                    'remarks' => trim((string) ($row['remarks'] ?? '')),
                ];
            })
            ->values()
            ->all();
    }

    private function paymentMethodOptions(Organizer $organizer): array
    {
        $config = $this->organizerConfig($organizer);
        $paymentMethodConfig = $config['payment_methods'] ?? [];

        return collect(self::QR_PAYMENT_METHOD_CONFIG_KEYS)
            ->filter(function ( string $configKey ) use ( $paymentMethodConfig ) {
                if ( empty($paymentMethodConfig) ) {
                    return true;
                }

                return !empty($paymentMethodConfig[$configKey]);
            })
            ->keys()
            ->map(function ( int $paymentMethod ) {
                return [
                    'value' => $paymentMethod,
                    'label' => $this->paymentMethodLabel($paymentMethod),
                ];
            })
            ->values()
            ->all();
    }

    private function organizerConfig(Organizer $organizer): array
    {
        foreach ( $this->organizerConfigKeyCandidates($organizer) as $candidateKey ) {
            $config = config($candidateKey, []);

            if ( is_array($config) && array_key_exists('payment_methods', $config) ) {
                return $config;
            }
        }

        $candidateKeys = collect($this->organizerConfigKeyCandidates($organizer))
            ->map(function ( string $key ) {
                return $this->normalizeConfigKey($key);
            })
            ->filter()
            ->unique()
            ->values()
            ->all();

        foreach ( config()->all() as $configKey => $config ) {
            if ( !is_array($config) || !array_key_exists('payment_methods', $config) ) {
                continue;
            }

            if ( in_array($this->normalizeConfigKey((string) $configKey), $candidateKeys, true) ) {
                return $config;
            }
        }

        return [];
    }

    private function organizerConfigKeyCandidates(Organizer $organizer): array
    {
        $rawKeys = [];

        foreach ( [ 'config_key', 'client_key', 'key', 'slug', 'code', 'domain_name', 'business_name', 'name' ] as $field ) {
            if ( !empty($organizer->{$field}) ) {
                $rawKeys[] = (string) $organizer->{$field};
            }
        }

        if ( !empty($organizer->business_name) ) {
            $rawKeys[] = Str::studly((string) $organizer->business_name);
            $rawKeys[] = str_replace(' ', '', (string) $organizer->business_name);
        }

        return collect($rawKeys)
            ->map(function ( string $key ) {
                return trim($key);
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function normalizeConfigKey(string $value): string
    {
        return Str::lower(preg_replace('/[^A-Za-z0-9]/', '', $value));
    }

    private function paymentMethodLabel(int $paymentMethod): string
    {
        if ( enum_exists(self::PAYMENT_METHOD_ENUM_CLASS) ) {
            foreach ( call_user_func([ self::PAYMENT_METHOD_ENUM_CLASS, 'cases' ]) as $case ) {
                if ( (int) $case->value !== $paymentMethod ) {
                    continue;
                }

                if ( method_exists($case, 'label') ) {
                    return $case->label();
                }

                return $case->name;
            }
        }

        return self::PAYMENT_METHOD_FALLBACK_LABELS[$paymentMethod] ?? 'Payment Method #' . $paymentMethod;
    }

    private function storePaymentQrCodeFile($file, int $organizerId, int $paymentMethod): string
    {
        $extension = Str::lower($file->getClientOriginalExtension() ?: 'png');
        $fileName = $paymentMethod . '-' . Str::random(20) . '.' . $extension;
        $path = $file->storeAs('organizers/' . $organizerId . '/payment-qr-codes', $fileName, 'public');

        return Storage::url($path);
    }

    private function deletePublicStorageUrl(string $url): void
    {
        $path = ltrim(parse_url($url, PHP_URL_PATH) ?? '', '/');

        if ( Str::startsWith($path, 'storage/') ) {
            $path = Str::after($path, 'storage/');
        }

        if ( $path !== '' && Storage::disk('public')->exists($path) ) {
            Storage::disk('public')->delete($path);
        }
    }

    private function unsetComputedOrganizerAttributes(Organizer $organizer): void
    {
        unset($organizer['hashid']);
        unset($organizer['full_name']);
        unset($organizer['type_text']);
    }
}