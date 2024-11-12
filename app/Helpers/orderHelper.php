<?php
namespace App\Helpers;

use App\Models\Order;
use App\Models\ProductOffers;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;


class orderHelper {

    public static function getProgress( $order ) {

        $status = $order->status->slug;
        $progress = 0;
        switch ($status) {
            case 'pending':
                $progress = 1;
                break;
            case 'processing':
                $progress = 2;
                break;
            case 'completed':
                $progress = 3;
                break;
        }

        return $progress;

    }

    public static function getCart( $order ) {

        $cart = [];
        foreach ($order->cartProducts as $cartProduct) {
            $productData = $cartProduct->product;
            
            // Product data
            $product = [
                'id' => $productData->id,
                'name' => $productData->name,
                'slug' => $productData->slug,
                'image' => $productData->image,
                'price' => $productData->price,
                'quantity' => $cartProduct->quantity,
                'total' => $productData->price * $cartProduct->quantity,
                'Model' => $productData,
            ];

            // Offer data
            $offerData = ProductOffers::find($cartProduct->offer_id); 
            $offer = [
                'id' => $offerData->id,
                'name' => $offerData->name,
                'price' =>  $offerData->price,
                'quantity' => $cartProduct->quantity,
                'total' =>  $offerData->price * $cartProduct->quantity,
                'Model' =>  $offerData,
            ];
            
            // Extras
            $extras = [];
            foreach ($productData->extras as $extra) {
                $extras[] = [
                    'id' => $extra->id,
                    'name' => $extra->name,
                    'price' => $extra->price,
                    'quantity' => $cartProduct->quantity,
                    'total' => $extra->price * $cartProduct->quantity,
                    'Model' => $extra,
                ];
            }

            $cart[] = [
                'product' => $product,
                'offer' => $offer,
                'extras' => $extras,
                'quantity' => $cartProduct->quantity,
                'price' => $cartProduct->price,
                'total' => $cartProduct->price * $cartProduct->quantity,
            ];
        }

        return $cart;

    }

    public static function uploadDocument($order_id, $request_file, $data = [])
    {

        $order = Order::find($order_id);

        $path = 'uploads/orders/'.$order_id.'/certificates';
        $disk = 'local';

        $file = request()->file($request_file);
        $filename = $file->getClientOriginalName();
        $filesize = $file->getSize();
        $type = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();

        // We set an origin filename to the file
        $filePath = request()->file($request_file)->storeAs($path, $filename, $disk);

        // Insert into the database
        $file = new File();
        $file->filename = $filename;
        $file->path = $filePath;
        $file->type = $type;
        $file->size = $filesize;
        $file->extension = $extension;
        $file->description = '';
        $file->disk = $disk;
        $file->visibility = 'private';
        $file->user_id = $order->user_id;
        $file->save();

        // Save the file path in the database
        $order = Order::find($order_id);
        $order->certificates()->create([
            'file_id' => $file->id,
        ]);

    }

    public static function SendMailOrderCreated($order) {

        // Find the user by user_id field in the order
        $user = User::find($order->user_id);

        if ($user) {
            // Send the email
            Mail::to($user->email)->send(new OrderCreated($order, $user));
        }

    }

    public static function checkUpdateStatus( $order_id ) {

        $order = Order::find($order_id);
        
        if( $order->isCompletedForm() ) {
            $order->setStatus( 2 );
        }

    }

}