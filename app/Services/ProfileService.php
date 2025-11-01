<?php

    namespace App\Services;

    use Stripe\Stripe;
    use App\Models\Cart;
    use App\Models\User;
    use App\Models\Order;
    use App\Models\OrderDetail;
    use Illuminate\Support\Facades\DB;

    class ProfileService
    {

        public function getUserProfileData(User $user): array
        {
            $orders = Order::with('details.product')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $totalSpent = $orders->sum('total_price');

            return [
                'user' => $user,
                'orders' => $orders,
                'totalSpent' => $totalSpent,
            ];
        }
        public function updateUserProfile(User $user, array $data): void
        {
            $user->update($data);
        }
        public function updateUserSettings(User $user, array $data): void
        {
            $data = array_filter($data, fn($value) => !is_null($value) && $value !== '');

            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            $user->update($data);
        }

        public function getWishlistProducts(User $user)
        {
            return $user->wishlists()->with('product')->latest()->get();
        }

        public function toggleWishlist(User $user, int $productId): bool
        {
            $wishlistItem = $user->wishlists()->where('product_id', $productId)->first();

            if ($wishlistItem) {
                $wishlistItem->delete();
                return false; // Removed from wishlist
            } else {
                $user->wishlists()->create(['product_id' => $productId]);
                return true; // Added to wishlist
            }
        }

    }
