<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_can_create_item_with_photo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.items.store'), [
            'name' => 'Kotak P3K',
            'description' => 'Perlengkapan pertolongan pertama',
            'category' => 'Medical',
            'total_quantity' => 4,
            'price' => 25000,
            'condition' => 'Good',
            'photo' => UploadedFile::fake()->image('kotak-p3k.jpg', 800, 600)->size(500),
        ]);

        $response->assertRedirect(route('admin.items.index'));
        $item = Item::where('name', 'Kotak P3K')->firstOrFail();
        $this->assertNotNull($item->photo);
        Storage::disk('public')->assertExists($item->photo);
    }

    public function test_borrower_can_submit_spj_as_image(): void
    {
        Storage::fake('public');
        $item = Item::create([
            'name' => 'Tandu Lipat',
            'category' => 'Medical',
            'total_quantity' => 2,
            'available_quantity' => 2,
            'price' => 50000,
            'condition' => 'Good',
        ]);
        $sessionId = 'test-cart-session';
        Cart::create(['session_id' => $sessionId, 'item_id' => $item->id, 'quantity' => 1]);

        $response = $this->withSession(['cart_session_id' => $sessionId])->post(route('borrowings.store'), [
            'borrower_name' => 'Anggota KSR',
            'phone' => '081234567890',
            'organization' => 'KSR PMI',
            'borrow_date' => now()->addDay()->toDateString(),
            'return_date' => now()->addDays(2)->toDateString(),
            'purpose' => 'Pelatihan pertolongan pertama',
            'spj' => UploadedFile::fake()->image('spj-kegiatan.png', 1200, 1600)->size(800),
        ]);

        $borrowing = \App\Models\Borrowing::firstOrFail();
        $response->assertRedirect(route('borrowings.success', ['code' => $borrowing->code_number]));
        Storage::disk('public')->assertExists($borrowing->spj);
    }

    public function test_admin_can_add_photo_when_updating_existing_item(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);
        $item = Item::create([
            'name' => 'Tandu Lipat',
            'description' => 'Belum memiliki foto',
            'category' => 'Medical',
            'total_quantity' => 5,
            'available_quantity' => 5,
            'price' => 50000,
            'condition' => 'Good',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.items.update', $item), [
            'name' => $item->name,
            'description' => $item->description,
            'category' => $item->category,
            'total_quantity' => $item->total_quantity,
            'price' => $item->price,
            'condition' => $item->condition,
            'photo' => UploadedFile::fake()->image('tandu-baru.png', 800, 600)->size(600),
        ]);

        $response->assertRedirect(route('admin.items.index'));
        $item->refresh();
        $this->assertNotNull($item->photo);
        Storage::disk('public')->assertExists($item->photo);
    }
}
