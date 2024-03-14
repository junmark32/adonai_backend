<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\ProductModel;

class AdminController extends BaseController
{
    public function index()
    {
        return view('admin/index');
    }

    public function showProducts()
    {
        // Load the ProductModel
        $productModel = new ProductModel();

        // Retrieve all products from the database
        $products = $productModel->findAll();

        // Pass the products data to the view
        $data['products'] = $products;

        return view('admin/product', $data);
    }

    public function addProduct()
    {
        return view('admin/add_product');
    }

    public function insertProduct()
    {
        $productModel = new ProductModel();

        // Process image upload
        $image = $this->request->getFile('image'); // Assuming you're uploading an image via a form with name 'image'

        // Check if image was uploaded successfully
        if ($image->isValid() && !$image->hasMoved()) {
            // Generate a unique filename
            $imageName = $image->getRandomName();

            // Move uploaded image to the uploads directory
            $image->move(ROOTPATH . 'public/uploads', $imageName);

            // Define product data
            $data = [
                'Image_url' => $imageName, // Relative path to the image
                'Name' => $this->request->getPost('name'),
                'Brand' => $this->request->getPost('brand'),
                'Type' => $this->request->getPost('type'),
                'Price' => $this->request->getPost('price'),
                'StockQuantity' => $this->request->getPost('stock_quantity'),
                'Faceshape' => $this->request->getPost('faceshape'),
                'Frameshape' => $this->request->getPost('frameshape'),
                'Material' => $this->request->getPost('material'),
                'Gender' => $this->request->getPost('gender'),
                'Frameage' => $this->request->getPost('frameage'),
                'Framesize' => $this->request->getPost('framesize'),
                'Fullframesize' => $this->request->getPost('fullframesize'),
                'Nosebridgesize' => $this->request->getPost('nosebridgesize'),
                'Templesize' => $this->request->getPost('templesize'),
                'Note' => $this->request->getPost('note')
            ];

            // Insert product data into the database
            $productModel->insert($data);

            // Optionally, redirect or return a response
            // For example:
            return redirect()->to('/Admin/Products')->with('success', 'Product added successfully');
        } else {
            // Handle image upload failure
            // For example:
            // return redirect()->to('/add-product')->with('error', 'Failed to upload image');
        }
    }




}
