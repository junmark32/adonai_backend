<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\ProductModel;
use App\Models\PurchaseModel;
use App\Models\PatientModel;
use App\Models\ProdHistoryModel;
use App\Models\AppointmentModel;
use App\Models\ScheduleModel;
use Dompdf\Dompdf;
use Dompdf\Options;
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
        $purchaseModel = new PurchaseModel();
        $patientModel = new PatientModel();

        // Retrieve all products from the database
        $products = $productModel->findAll();
        // Count products where StockQuantity is 0
        $soldCount = $productModel->where('StockQuantity', 0)->countAllResults();


       // Count purchases where Status is 'Pending'
        $purchaseCount = $purchaseModel->where('Status', 'Pending')->countAllResults();

        // Count purchases where Status is 'On-Process'
        $onprocessCount = $purchaseModel->where('Status', 'On-Process')->countAllResults();

        // Count purchases where Status is 'Returned'
        $returnedCount = $purchaseModel->where('Status', 'Returned')->countAllResults();

        $completeCount = $purchaseModel->where('Status', 'Completed')->countAllResults();

        //
        // Get the current year
        $currentYear = date('Y');


        $purchaseDailyData = $purchaseModel->select('DATE_FORMAT(PurchaseDate, "%Y-%m-%d") as y, COUNT(PurchaseID) as a')
        ->where('YEAR(PurchaseDate)', $currentYear)
        ->where('Status', 'Completed')
        ->groupBy('DATE_FORMAT(PurchaseDate, "%Y-%m-%d")')
        ->findAll();

        //
        // Join tables 1
        $builder1 = $purchaseModel->builder();
        $builder1->select('purchases.PurchaseID, patients.FirstName, patients.LastName, patients.Email, p1.Name as ProductName, l1.Brand as LensBrand, purchases.Status, purchases.Quantity, purchases.TotalAmount, purchases.PurchaseDate');
        $builder1->join('patients', 'patients.UserID = purchases.UserID');
        $builder1->join('products p1', 'p1.ProductID = purchases.EyewearID');
        $builder1->join('lenses l1', 'l1.LensID = purchases.LensID');
        $builder1->orderBy('purchases.PurchaseDate', 'DESC');
        $data['purchases'] = $builder1->get()->getResult();

        $builder2 = $purchaseModel->builder();
        $builder2->select('p2.Image_url, p2.Name, p2.Brand, p2.Type, purchases.EyewearID, l.Brand as LensBrand, SUM(purchases.Quantity) as TotalQuantity');
        $builder2->join('products p2', 'p2.ProductID = purchases.EyewearID');
        $builder2->join('lenses l', 'l.LensID = purchases.LensID'); // Join with lenses table
        $builder2->groupBy('purchases.EyewearID, p2.Image_url, p2.Name, p2.Brand, p2.Type, l.Brand');
        $builder2->orderBy('TotalQuantity', 'DESC');
        $data['bestselling'] = $builder2->get()->getResult();

        


        $data['purchaseDailyData'] = $purchaseDailyData;

        // Assign counts to data array
        $data['purchaseCount'] = $purchaseCount;
        $data['onprocessCount'] = $onprocessCount;
        $data['returnedCount'] = $returnedCount;
        $data['completeCount'] = $completeCount;
        $data['soldCount'] = $soldCount;

        // Pass the products data to the view
        $data['products'] = $products;

        return view('admin/product', $data);
    }

    // Method to update purchase status
public function updateStatus()
{
    // Ensure this method is accessed via POST
    if ($this->request->getMethod() === 'post') {
        // Get the purchase_id and status from POST data
        $purchaseId = $this->request->getPost('purchase_id');
        $status = $this->request->getPost('status');

        // Load the PurchaseModel (replace with your actual model name)
        $purchaseModel = new PurchaseModel();

        // Update the status in the database
        $data = [
            'Status' => $status
        ];

        $updated = $purchaseModel->update($purchaseId, $data);

        if ($updated) {
            // Status updated successfully
            // Prepare JSON response
            $response = [
                'success' => true,
                'message' => 'Status updated successfully.',
                'status' => $status // Optionally include updated status
            ];
        } else {
            // Failed to update status
            // Prepare JSON response
            $response = [
                'success' => false,
                'message' => 'Failed to update status.'
            ];
        }

        // Return JSON response
        return $this->response->setJSON($response);
    } else {
        // Handle invalid request method (should not be accessed directly)
        // Prepare JSON response for invalid request method
        $response = [
            'success' => false,
            'message' => 'Invalid request method.'
        ];

        return $this->response->setJSON($response);
    }
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

    public function editProduct($productID)
    {
        // Load the product model
        $productModel = new ProductModel();

        // Retrieve the product data based on the product ID
        $product = $productModel->find($productID);

        // Dump the contents and type of the $products variable
        // var_dump($products);


        // Check if the product exists
        // if (!$product) {
        //     // Product not found, redirect or show error message
        //     return redirect()->to('/admin/products')->with('error', 'Product not found');
        // }

        // Pass the product data to the view for editing
        return view('admin/update_product', ['product' => $product]);
    }

    public function updateProduct()
{
    $productModel = new ProductModel();
    $prodHistoryModel = new ProdHistoryModel();

    // Retrieve the product ID from the form data
    $productID = $this->request->getPost('product_id')[0]; // Assuming there's only one product ID

    // Retrieve existing product data
    $product = $productModel->find($productID);

    // Check if product exists
    if (!$product) {
        // Handle case where product does not exist
        return redirect()->to('/Admin/Products')->with('error', 'Product not found');
    }

    // Process image upload
    $image = $this->request->getFile('image'); // Assuming you're uploading an image via a form with name 'image'

    // Initialize the variable to hold the image URL
    $imageName = '';

    // Check if image was uploaded successfully
    if ($image && $image->isValid() && !$image->hasMoved()) {
        // Generate a unique filename
        $imageName = $image->getRandomName();

        // Move uploaded image to the uploads directory
        $image->move(ROOTPATH . 'public/uploads', $imageName);
    }

    // Define updated product data
    $data = [
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

    // If a new image was uploaded, include it in the data array
    if (!empty($imageName)) {
        $data['Image_url'] = $imageName;
    }

    // Update product data in the database
    $productModel->update($productID, $data);

    // Define product data
    $data1 = [
        'ProductID' => $productID,
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
    $prodHistoryModel->insert($data1);

    // Optionally, redirect or return a response
    // For example:
    return redirect()->to('/Admin/Products')->with('success', 'Product updated successfully');
}

public function generateReport()
    {
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        // Fetch the data
        $purchaseModel = new PurchaseModel();
        $builder1 = $purchaseModel->builder();
        $builder1->select('purchases.PurchaseID, patients.FirstName, patients.LastName, patients.Email, p1.Name as ProductName, p1.Price as ProductPrice, l1.Brand as LensBrand, l1.Price as LensPrice, purchases.Status, purchases.Quantity, purchases.TotalAmount, purchases.PurchaseDate');
        $builder1->join('patients', 'patients.UserID = purchases.UserID');
        $builder1->join('products p1', 'p1.ProductID = purchases.EyewearID');
        $builder1->join('lenses l1', 'l1.LensID = purchases.LensID');
        if ($startDate && $endDate) {
            $builder1->where('purchases.PurchaseDate >=', $startDate);
            $builder1->where('purchases.PurchaseDate <=', $endDate);
        }
        $data['purchases'] = $builder1->get()->getResult();
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;

        // Load view and render HTML
        $html = view('reports/prod_report_view', $data);

        // Initialize DOMPDF
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("report.pdf", ["Attachment" => 0]);
    }


    public function updateScheduleStatus()
{
    $appointmentModel = new AppointmentModel();
    $scheduleTimingsModel = new ScheduleModel(); // Assuming you have a model for schedule_timings
    $today = date('Y-m-d'); // Get today's date in YYYY-MM-DD format

    // Set timezone to match your database timezone
    $timezone = new \DateTimeZone('Asia/Manila');
    $currentTime = new \DateTime('now', $timezone); // Get current time with timezone
    $formattedTime = $currentTime->format('H:i:s'); // Format the time

    // Update appointments that are ongoing
    $appointmentModel->where('Pref_Date', $today)
                     ->where('Pref_Time_Start <=', $formattedTime)
                     ->where('Pref_Time_End >=', $formattedTime)
                     ->set('Status', 'On-Going')
                     ->update();

    // Update appointments that are complete
    $appointmentModel->where('Pref_Date', $today)
                     ->where('Pref_Time_End <', $formattedTime)
                     ->set('Status', 'Complete')
                     ->update();

     // Fetch appointments where Pref_Date is before today
     $appointments = $appointmentModel->where('Pref_Date <', $today)->findAll();

     // Update schedule timings based on fetched appointments
     foreach ($appointments as $appointment) {
         $scheduleTimingsModel->where('id', $appointment['Pref_Timeslot_ID'])
                              ->set('status', 'Available')
                              ->update();
     }

    // Optional: return redirect or a response
    // return redirect()->to('/appointments');
}


    





}
