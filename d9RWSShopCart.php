<?php declare(strict_types=1);
/* 
    Purpose: Demo 9 - Class for creating a ShopCart object and managing cart items
    Author: LV
    Date: March 2021
 */

class d9RWSShopCart
{
   //Properties

    private array $cartItems;

   // Constructor

    public function __construct()
    {
        $this->cartItems = array();
    }

   // add an item to the $cartItems array

    public function addCartItem(int $aMerchandiseID) : void
    {
        // if the item is not already in the array, add the item to the array

        if (!array_key_exists($aMerchandiseID, $this->cartItems))
        {
            $this->cartItems[$aMerchandiseID] = 1;
        }

        // else, increase the quantity for the item by one
        else
        {
            $this->cartItems[$aMerchandiseID] ++;
        }
    }

    // return the $cartItems array

    public function getCartItems() : array
    {
        return $this->cartItems;
    }

    // return the quantity for a specific item

    public function getQtyByMerchandiseID(int $aMerchandiseID) : int
    {
        return $this->cartItems[$aMerchandiseID];
    }

    // update the quantity for a specific item

    public function updateCartItem(int $aMerchandiseID, int $aOrderQty) : void
    {
        if ($aOrderQty === 0)
        {
            $this->deleteCartItem($aMerchandiseID);
        }
        else
        {
            $this->cartItems[$aMerchandiseID] = $aOrderQty;
        }
    }

    // delete a specific item from the array

    public function deleteCartItem(int $aMerchandiseID) : void
    {
        unset($this->cartItems[$aMerchandiseID]);
    }
}
?>
