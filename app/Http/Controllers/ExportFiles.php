<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Product;
    use App\Models\store_movemnts_orders;
    use App\Models\store_movemnts_details;
    use App\Models\transfer_orders;
    use App\Models\transfer_details;
    use App\Models\store1s;
    use App\Models\store2s;
    use App\Models\store3s;
    use App\Models\store4s;
    use App\Models\Category;
    use App\Models\quotations;
    use App\Models\quotation_details;
    use Maatwebsite\Excel\Facades\Excel;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use DB;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
class ExportFiles extends Controller
{
    protected $product;
    protected $store_movemnts_orders;
    
    public function __construct(Product $product,store_movemnts_orders $store_movemnts_orders, store_movemnts_details $store_movemnts_details, transfer_orders $transfer_orders,transfer_details $transfer_details, quotations $quotations, quotation_details $quotation_details )
    {
        $this->product = $product;
        $this->store_movemnts_orders = $store_movemnts_orders;
        $this->store_movemnts_details = $store_movemnts_details;
        $this->transfer_orders = $transfer_orders;
        $this->transfer_details = $transfer_details;
        $this->quotations = $quotations;
        $this->quotation_details = $quotation_details;
    }

    public function stock($store, $product_id){
        $stock =0;
        if ($store === 'store1s') {
            $stock = DB::table('store1s')->select('stock')->where('pro_id', $product_id)->first();
        } 
        if ($store === 'store2s') {
            $stock = DB::table('store2s')->select('stock')->where('pro_id', $product_id)->first();
        } 
        if ($store === 'store3s') {
            $stock = DB::table('store3s')->select('stock')->where('pro_id', $product_id)->first();
        } 
        if ($store === 'store4s') {
            $stock = DB::table('store4s')->select('stock')->where('pro_id', $product_id)->first();
        } 
        if ($stock) {
            $stock = $stock->stock;
            }
        else{
            $stock = 0;
        }
        return $stock;
    }
    public function allprodct_stock($product_id){
        $sp_product = DB::table('store1s')->select('stock')->where('pro_id', $product_id)->first();
        $mp_product = DB::table('store2s')->select('stock')->where('pro_id', $product_id)->first();
        $ap_product = DB::table('store3s')->select('stock')->where('pro_id', $product_id)->first();
        $p_product = DB::table('store4s')->select('stock')->where('pro_id', $product_id)->first();
        $total_stock = 0;
    
        if ($sp_product) {
            $total_stock += $sp_product->stock;
        }
        if ($mp_product) {
            $total_stock += $mp_product->stock;
        }
        if ($ap_product) {
            $total_stock += $ap_product->stock;
        }
        if ($p_product) {
            $total_stock += $p_product->stock;
        } 
    
        return $total_stock;
    }
    
    public function export() 
    {  
        try {
            $product_list = $this->product->product_list();
            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
    
            // Set column headers
            $activeWorksheet->setCellValue('A1', 'ID');
            $activeWorksheet->setCellValue('B1', 'Title');
            $activeWorksheet->setCellValue('C1', 'Category');
            $activeWorksheet->setCellValue('D1', 'Stock');
            $activeWorksheet->setCellValue('E1', 'Barcode');
            $activeWorksheet->setCellValue('F1', 'Description');
            $activeWorksheet->setCellValue('G1', 'Max Price');
            $activeWorksheet->setCellValue('H1', 'Price');
            $activeWorksheet->setCellValue('I1', 'Min Price');
    
            // Populate data rows
            $sn = 2;
            foreach($product_list as $product){
                $category = DB::table('categories')->where('id', $product->cat_id)->select('title')->first();
                $categoryTitle = $category ? $category->title : 'N/A';
                $stock = $this->allprodct_stock($product->id); // Call the function using $this
                if ($stock > 0){
                $activeWorksheet->setCellValue('A'.$sn, $product->id);
                $activeWorksheet->setCellValue('B'.$sn, $product->title);
                $activeWorksheet->setCellValue('C'.$sn, $categoryTitle);
                $activeWorksheet->setCellValue('D'.$sn, $stock);
                $activeWorksheet->setCellValue('E'.$sn, $product->barcode);
                $activeWorksheet->setCellValue('F'.$sn, $product->description);
                $activeWorksheet->setCellValue('G'.$sn, $product->maxprice);
                $activeWorksheet->setCellValue('H'.$sn, $product->price);
                $activeWorksheet->setCellValue('I'.$sn, $product->minprice);
            
                $sn++;
            }
        }
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            
            // Output the Excel file to the browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="products.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage());
        }
    }


    // Export one stock 
    public function export_stock($store) 
    {  
        try {
            $product_list = $this->product->product_list();
            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
    
            // Set column headers
            $activeWorksheet->setCellValue('A1', 'ID');
            $activeWorksheet->setCellValue('B1', 'Title');
            $activeWorksheet->setCellValue('C1', 'Category');
            $activeWorksheet->setCellValue('D1', 'Stock');
            $activeWorksheet->setCellValue('E1', 'Barcode');
            $activeWorksheet->setCellValue('F1', 'Description');
            $activeWorksheet->setCellValue('G1', 'Max Price');
            $activeWorksheet->setCellValue('H1', 'Price');
            $activeWorksheet->setCellValue('I1', 'Min Price');
    
            // Populate data rows
            $sn = 2;
            foreach($product_list as $product1){
                $category = DB::table('categories')->where('id', $product1->cat_id)->select('title')->first();
                $categoryTitle = $category ? $category->title : 'N/A';
                $stock = $this->stock($store, $product1->id); // Call the function using $this
                if ($stock > 0){
                $activeWorksheet->setCellValue('A'.$sn, $product1->id);
                $activeWorksheet->setCellValue('B'.$sn, $product1->title);
                $activeWorksheet->setCellValue('C'.$sn, $categoryTitle);
                $activeWorksheet->setCellValue('D'.$sn, $stock);
                $activeWorksheet->setCellValue('E'.$sn, $product1->barcode);
                $activeWorksheet->setCellValue('F'.$sn, $product1->description);
                $activeWorksheet->setCellValue('G'.$sn, $product1->maxprice);
                $activeWorksheet->setCellValue('H'.$sn, $product1->price);
                $activeWorksheet->setCellValue('I'.$sn, $product1->minprice);
            
                $sn++;
            }
        }
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            
            // Output the Excel file to the browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="products.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage());
        }
    }
    
//orders

   
    public function envoy_store($store){
        if ($store === 'store1') {
            $store_name = 'الرياض';
        }
        if ($store === 'store2') {
            $store_name = 'الغربية';
        } 
    
        return $store_name;
    }

    public function export_store_movemnts_details($id, $sn, $activeWorksheet) 
    {  
        $sn++;
            $details = $this->store_movemnts_details->store_details($id);
            $activeWorksheet->setCellValue('B'.$sn,'ID');
            $activeWorksheet->setCellValue('C'.$sn, 'product');
            $activeWorksheet->setCellValue('D'.$sn, 'quantity');

            // Populate data rows
            $sn++;
            foreach($details as $detail){
                $product = DB::table('products')->where('id', $detail->pro_id)->select('title')->first();
                $title = $product ? $product->title : 'N/A';
                $activeWorksheet->setCellValue('B'.$sn, $detail->id);
                $activeWorksheet->setCellValue('C'.$sn, $title);
                $activeWorksheet->setCellValue('D'.$sn, $detail->quantity);
                $sn++;
             }
        return $sn;
    }
    public function store_headers($activeWorksheet){
            $activeWorksheet->setCellValue('A1', 'ID');
            $activeWorksheet->setCellValue('B1', 'اسم الزبون');
            $activeWorksheet->setCellValue('C1', ' اسم المندوب الذي قام بالطلبية');
            $activeWorksheet->setCellValue('D1', 'الشحن ');
            $activeWorksheet->setCellValue('E1', 'نوع الطلب');
            $activeWorksheet->setCellValue('F1', 'Order name');
            $activeWorksheet->setCellValue('G1', 'المستودع');
            $activeWorksheet->setCellValue('H1', 'تاريخ الاخراج');
            $activeWorksheet->setCellValue('I1', 'rec_num');
            $activeWorksheet->setCellValue('J1', 'ملاحظات');
            $activeWorksheet->setCellValue('K1', 'اسم المندوب المستلم');
            $activeWorksheet->setCellValue('L1', 'رقم ايصال الاخراج');
            $activeWorksheet->setCellValue('M1', 'تاريخ انشاء الطلب الفعلي');
    }

    public function  order_type($order_type){
        if ($order_type == 'in') {
            $type = 'مرتجع' ;
        } else {
            $type = 'طلبية' ;
        }
        return $type;
    }

    public function export_store_movemnts() 
    {  
        try {
            $store_orders = $this->store_movemnts_orders->store_orders();
            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
    
            // Set column headers
            $this->store_headers($activeWorksheet);
    
            // Populate data rows
            $sn = 2;
            foreach($store_orders as $orser_store){
                $user = DB::table('users')->where('id', $orser_store->user_id)->select('name')->first();
                $name = $user ? $user->name : 'N/A';
                $shipping_id = DB::table('shippings')->where('id', $orser_store->shipping_id)->select('type')->first();
                $shipping = $shipping_id ? $shipping_id->type : 'N/A';
                $srtor_name = $this->envoy_store($orser_store->store); 
                $order_type = $this->order_type($orser_store->order_type); 
                $activeWorksheet->setCellValue('A'.$sn, $orser_store->id);
                $activeWorksheet->setCellValue('B'.$sn, $orser_store->cust);
                $activeWorksheet->setCellValue('C'.$sn, $name);
                $activeWorksheet->setCellValue('D'.$sn, $shipping);
                $activeWorksheet->setCellValue('E'.$sn, $order_type);
                $activeWorksheet->setCellValue('F'.$sn, $orser_store->order_name);
                $activeWorksheet->setCellValue('G'.$sn, $srtor_name);
                $activeWorksheet->setCellValue('H'.$sn, $orser_store->rece_date);
                $activeWorksheet->setCellValue('I'.$sn, $orser_store->rec_num);
                $activeWorksheet->setCellValue('J'.$sn, $orser_store->notes);
                $activeWorksheet->setCellValue('K'.$sn, $orser_store->env_name);
                $activeWorksheet->setCellValue('L'.$sn, $orser_store->cont_num);
                $activeWorksheet->setCellValue('M'.$sn, $orser_store->created_at);
                $sn = $this->export_store_movemnts_details($orser_store->id, $sn, $activeWorksheet); 
                $sn++;
             }
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            
            // Output the Excel file to the browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="store_movments_orders.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage());
        }
    }

  
    public function export_show_store_movemnts($id) 
    {  
        try {
            $store_orders = $this->store_movemnts_orders->one_store_orders($id);
            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
    
            // Set column headers
            $this->store_headers($activeWorksheet);
    
            // Populate data rows
            $sn = 2;
            $user = DB::table('users')->where('id', $store_orders->user_id)->select('name')->first();
            $name = $user ? $user->name : 'N/A';
            $shipping_id = DB::table('shippings')->where('id', $store_orders->shipping_id)->select('type')->first();
            $shipping = $shipping_id ? $shipping_id->type : 'N/A';
            $srtor_name = $this->envoy_store($store_orders->store);
            $order_type = $this->order_type($store_orders->order_type);
            $activeWorksheet->setCellValue('A'.$sn, $store_orders->id);
            $activeWorksheet->setCellValue('B'.$sn, $store_orders->cust);
            $activeWorksheet->setCellValue('C'.$sn, $name);
            $activeWorksheet->setCellValue('D'.$sn, $shipping);
            $activeWorksheet->setCellValue('E'.$sn, $order_type);
            $activeWorksheet->setCellValue('F'.$sn, $store_orders->order_name);
            $activeWorksheet->setCellValue('G'.$sn, $srtor_name);
            $activeWorksheet->setCellValue('H'.$sn, $store_orders->rece_date);
            $activeWorksheet->setCellValue('I'.$sn, $store_orders->rec_num);
            $activeWorksheet->setCellValue('J'.$sn, $store_orders->notes);
            $activeWorksheet->setCellValue('K'.$sn, $store_orders->env_name);
            $activeWorksheet->setCellValue('L'.$sn, $store_orders->cont_num);
            $activeWorksheet->setCellValue('M'.$sn, $store_orders->created_at);
            $sn = $this->export_store_movemnts_details($store_orders->id, $sn, $activeWorksheet); 
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
            // $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
            // Output the Excel file to the browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="store_movments_orders_show.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage());
        }
    }
// ................................................................................................

    public function store_name($store){
        
        if ($store === 'store1s') {
            $store_name = 'الرياض';
        }else
        if ($store === 'store2s') {
            $store_name = 'الغربية';
        }else 
        if ($store === 'store3s') {
            $store_name = 'سرداب';
        } else
        if ($store === 'store4s') {
            $store_name = 'عليا';
        }else{
            $store_name = 'خارجي';
        } 
        return $store_name;
    }


    public function export_transfer_details($id, $sn, $activeWorksheet) 
    {  
        $sn++;
            $details = $this->transfer_details->t_details($id);
            $activeWorksheet->setCellValue('B'.$sn,'ID');
            $activeWorksheet->setCellValue('C'.$sn, 'product');
            $activeWorksheet->setCellValue('D'.$sn, 'quantity');

            // Populate data rows
            $sn++;
            foreach($details as $detail){
                $product = DB::table('products')->where('id', $detail->pro_id)->select('title')->first();
                $title = $product ? $product->title : 'N/A';
                $activeWorksheet->setCellValue('B'.$sn, $detail->id);
                $activeWorksheet->setCellValue('C'.$sn, $title);
                $activeWorksheet->setCellValue('D'.$sn, $detail->quantity);
                $sn++;
             }
        return $sn;
    }
    public function header($activeWorksheet){
        $activeWorksheet->setCellValue('A1', 'ID');
        $activeWorksheet->setCellValue('B1', 'رقم ايصال الاخراج');
        $activeWorksheet->setCellValue('C1', 'اسم المندوب');
        $activeWorksheet->setCellValue('D1', 'تاريخ  ');
        $activeWorksheet->setCellValue('E1', 'نوع الطلب');
        $activeWorksheet->setCellValue('F1', 'من');
        $activeWorksheet->setCellValue('G1', 'الى');
        $activeWorksheet->setCellValue('H1', 'المستلم');
    }

    public function export_transfer_orders() 
    {  
        try {
            $transfer_orders = $this->transfer_orders->transfer_list();
            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
            // Set column headers
            $this->header($activeWorksheet);
            // Populate data rows
            $sn = 2;
            foreach($transfer_orders as $orser_store){
                $user = DB::table('users')->where('id', $orser_store->user_id)->select('name')->first();
                $name = $user ? $user->name : 'N/A';
                $shipping_id = DB::table('shippings')->where('id', $orser_store->shipping_id)->select('type')->first();
                $shipping = $shipping_id ? $shipping_id->type : 'N/A';
                $srtor_name = $this->store_name($orser_store->store); 
                $srtor2_name = $this->store_name($orser_store->deliverer); 
                $activeWorksheet->setCellValue('A'.$sn, $orser_store->id);
                $activeWorksheet->setCellValue('B'.$sn, $orser_store->rec_num);
                $activeWorksheet->setCellValue('C'.$sn, $name);
                $activeWorksheet->setCellValue('D'.$sn, $orser_store->rece_date);
                $activeWorksheet->setCellValue('E'.$sn, $orser_store->order_name);
                $activeWorksheet->setCellValue('F'.$sn, $srtor_name);
                $activeWorksheet->setCellValue('G'.$sn, $srtor2_name);
                $activeWorksheet->setCellValue('H'.$sn, $orser_store->recipient);
                $sn = $this->export_transfer_details($orser_store->id, $sn, $activeWorksheet); 
                $sn++;
             }
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            
            // Output the Excel file to the browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="inbound_orders.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage());
        }
    }

    //show exports
    public function export_one_transfer_order($id) 
    {  
        try {
            $transfer_orders = $this->transfer_orders->transfer($id);
            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
    
            // Set column headers
            $this->header($activeWorksheet);
            //data
            $sn = 2;
            $user = DB::table('users')->where('id', $transfer_orders->user_id)->select('name')->first();
            $name = $user ? $user->name : 'N/A';
            $shipping_id = DB::table('shippings')->where('id', $transfer_orders->shipping_id)->select('type')->first();
            $shipping = $shipping_id ? $shipping_id->type : 'N/A';
            $activeWorksheet->setCellValue('A'.$sn, $transfer_orders->id);
            $activeWorksheet->setCellValue('B'.$sn, $transfer_orders->rec_num);
            $activeWorksheet->setCellValue('C'.$sn, $name);
            $activeWorksheet->setCellValue('D'.$sn, $transfer_orders->rece_date);
            $activeWorksheet->setCellValue('F'.$sn, $transfer_orders->order_name);
            $activeWorksheet->setCellValue('G'.$sn, $transfer_orders->store);
            $activeWorksheet->setCellValue('H'.$sn, $transfer_orders->deliverer);
            $activeWorksheet->setCellValue('I'.$sn, $transfer_orders->recipient);
            $sn = $this->export_transfer_details($transfer_orders->id, $sn, $activeWorksheet); 
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            
            // Output the Excel file to the browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="inbound_orders_show.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            dd($e->getMessage());
        }
    }
//qutations

        // public function export_price($id){
        // // Load your spreadsheet
        // try {

        //         // Load the original Excel file
        //         $spreadsheet = IOFactory::load("templets/ss.xlsx");
        //         $sheet = $spreadsheet->getActiveSheet();
        //         $sheet->setCellValue('A1', 'Hello World!');
            
        //         // Save the modified spreadsheet to a new file
        //         $filename = 'modified_ss.xlsx';
        //         $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        //         $writer->save($filename);
            
        //         // Send the new file to the client for download
        //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //         header('Content-Disposition: attachment;filename="' . $filename . '"');
        //         header('Cache-Control: max-age=0');
        //         readfile($filename);
        //         unlink($filename); // Delete the temporary file after download
        //         exit;
            
        // } catch (\Exception $e) {
        //     echo 'Error: ' . $e->getMessage();
        // }
        // }
    public function export_price(Request $request, $id){
        try{
            //load the templet
            $qutation = $this->quotations->quotations_list($id);
            $spreadsheet = IOFactory::load("templets/ss.xlsx");
            $activeWorksheet = $spreadsheet->getActiveSheet();
            //add contents
            $activeWorksheet->setCellValue('C3', $qutation->created_at);
            $activeWorksheet->setCellValue('C4', $qutation->qut_num);
            // $activeWorksheet->mergeCells('G1:I3');
            $activeWorksheet->setCellValue('C5', $qutation->customer);
            if ($qutation->title == 1) {
            $activeWorksheet->setCellValue('F3', 'عرض سعر');
            $activeWorksheet->setCellValue('F4', 'Qutation');
        } else if ($qutation->title == 2){
            $activeWorksheet->setCellValue('F3', 'عرض خدمة تعطير');
            $activeWorksheet->setCellValue('F4', 'Rental Quotation');
          
        }else{
            $activeWorksheet->setCellValue('F3', 'عرض خدمة استبدال');
            $activeWorksheet->setCellValue('F4', 'Device replacement Quotation');

        }
        

        $user = DB::table('users')->where('id', $qutation->user_id)->select('name')->first();
        $name = $user ? $user->name : 'N/A';
        // Set column headers
        $activeWorksheet->setCellValue('B16', 'البائع المسؤول');
        $activeWorksheet->setCellValue('E16', 'وقت التسليم');
        $activeWorksheet->setCellValue('G16', 'طريقة الدفع');
        $activeWorksheet->setCellValue('H16', 'مدة العرض');
        $activeWorksheet->setCellValue('B17', $name);
        $activeWorksheet->setCellValue('E17', $qutation->delevery_date);
        $activeWorksheet->setCellValue('G17', $qutation->payments_terms);
        $activeWorksheet->setCellValue('H17', $qutation->time_valided);
        // style
        $style = $activeWorksheet->getStyle('B15');
        $style->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // Populate data rows
        // $drawing = new Drawing();
        // $drawing->setName('qrcode');
        // $drawing->setDescription('Image Description');
        // $drawing->setPath('templets/qrcode.png'); // Path to the image file
        // $drawing->setCoordinates('F7'); // Cell where the image will be inserted
        // $drawing->setOffsetX(5);
        // $drawing->setOffsetY(5);
        // $drawing->setWidth(1000);
        // $drawing->setHeight(1000);
        // $drawing->setResizeProportional(false); // Disable proportional resizing
        // $drawing->setWorksheet($activeWorksheet);
        $drawing = new Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('Image Description');
        $drawing->setPath('templets/logo.png'); // Path to the image file
        $drawing->setCoordinates('A7'); // Cell where the image will be inserted
        $drawing->setOffsetX(5);
        $drawing->setOffsetY(5);
        $drawing->setWidth(1000);
        $drawing->setHeight(1000);
        $drawing->setResizeProportional(false); // Disable proportional resizing
        $drawing->setWorksheet($activeWorksheet);
        $sn = 19;
        $sn = $this->export_qutation_details($qutation->id, $sn, $activeWorksheet); 
        $totalPriceSum = $this->totalPriceSum($qutation->id); 
        $totalvat = $this->totalvat($qutation->id); 
        //totales
        $sn +=2;
        $activeWorksheet->setCellValue('K'.$sn, number_format(($totalPriceSum-$totalvat),2));
        $sn++;
        $activeWorksheet->setCellValue('K'.$sn, number_format($totalvat,2));
        $sn++;
        $activeWorksheet->setCellValue('K'.$sn, $totalPriceSum);
        $sn +=4;
        $activeWorksheet->setCellValue('D'.$sn, 'SA45000000003157779900: رقم حساب البنك الرياض');
        $sn++;
        $activeWorksheet->setCellValue('D'.$sn, 'Riyad Bank, account number: SA5420000002581567279940 ');
        if ($qutation->guarantee == 1) {
            $sn++;
            $activeWorksheet->setCellValue('D'.$sn,'The warranty period for the devices"s 2 years, including maintenance or replacement if the original is available.The invoice warranty ends in the event of misuse or use of another perfume not approved by the company.');
            $sn +=2;
            $activeWorksheet->setCellValue('D'.$sn,'مدة ضمان الأجهزة سنتين شاملة الصيانة أو الاستبدال في حالة توفر الفاتورة الأصل.وينتهي ضمان الفاتورة في حالة سوء الاستخدام أو استخدام عطر آخر غير معتمد من الشركة.');    
        }
        // $filename = 'modified_ss.xlsx';
        // $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        // $writer->save($filename);
    
        // // Send the new file to the client for download
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');
        // readfile($filename);
        // unlink($filename); // Delete the temporary file after download
        // exit;
        $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
        \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
        $pdfWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        // Save the PDF to a temporary file
        $pdfFilename = 'modified_ss.pdf';
        $pdfWriter->save($pdfFilename);
    
        // Send the PDF file to the client for download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $pdfFilename . '"');
        header('Cache-Control: max-age=0');
        readfile($pdfFilename);
        unlink($pdfFilename); // Delete the temporary file after download
        exit;

        
        }  catch (Exception $e) {
            echo 'Error loading the Excel file: ' . $e->getMessage();
        }

    }

    public function export_qutation_details($id, $sn, $activeWorksheet) 
    {  
            $details = $this->quotation_details->qutation_details($id);
            // Populate data rows
            $activeWorksheet->setCellValue('B'.$sn,'الوصف');
            $activeWorksheet->setCellValue('C'.$sn, 'الصورة');
            $activeWorksheet->setCellValue('D'.$sn, 'الكمية');
            $activeWorksheet->setCellValue('E'.$sn, 'السعر');
            $activeWorksheet->setCellValue('F'.$sn, 'الحسم');
            $activeWorksheet->setCellValue('G'.$sn, 'السعر بعد الحسم');
            $activeWorksheet->setCellValue('H'.$sn, 'صافي السعر');
            $activeWorksheet->setCellValue('I'.$sn, 'ضريبة القيمة المضافة');
            $activeWorksheet->setCellValue('J'.$sn, 'الاجمالي الفرعي');
            $activeWorksheet->setCellValue('K'.$sn, 'الاجمالي');
            $activeWorksheet->setCellValue('L'.$sn, 'ملاحظات');
            $sn++;
            $row =1;
            foreach($details as $detail){
                $activeWorksheet->insertNewRowBefore($sn+1, 1);
                $product = DB::table('products')->where('id', $detail->pro_id)->select('title')->first();
                $photo = DB::table('products')->select('photo')->first();
                $activeWorksheet->setCellValue('A'.$sn, $row);
                $activeWorksheet->setCellValue('B'.$sn, $detail->vate);
                $drawing = new Drawing();
                $drawing->setName('Image'.$sn);
                $drawing->setDescription('Image Description');
                $drawing->setPath($photo->photo); // Path to the image file
                $drawing->setCoordinates('C'.$sn,); // Cell where the image will be inserted
                $drawing->setOffsetX(50);
                $drawing->setOffsetY(50);
                $drawing->setWidth(200);
                $drawing->setHeight(200);
                $drawing->setWorksheet($activeWorksheet);
                $activeWorksheet->setCellValue('D'.$sn, $detail->quantity);
                $activeWorksheet->setCellValue('E'.$sn, $detail->price);
                $activeWorksheet->setCellValue('F'.$sn, round((($detail->price-$detail->pro_dscont)/$detail->price)*100));
                $activeWorksheet->setCellValue('G'.$sn, $detail->pro_dscont);
                $activeWorksheet->setCellValue('H'.$sn, number_format(($detail-> pro_dscont/115*100),2));
                $activeWorksheet->setCellValue('I'.$sn, number_format($detail-> pro_dscont-($detail-> pro_dscont/115*100),2));
                $activeWorksheet->setCellValue('J'.$sn, ($detail->pro_dscont-($detail->pro_dscont/115*100))+($detail-> pro_dscont/115*100));
                $activeWorksheet->setCellValue('K'.$sn, ((($detail->pro_dscont-($detail-> pro_dscont/115*100))+($detail-> pro_dscont/115*100))* $detail->quantity));
                $activeWorksheet->setCellValue('L'.$sn, $detail->notes);
                $sn++;
                $row++;
             }
        return $sn;
    }
//
    public function totalPriceSum($id){
        $details = $this->quotation_details->qutation_details($id);
         $totalPriceSum = 0; 
        foreach($details as $detail){
            // Assuming $detail->price * $detail->quantity represents the "TOTAL PRICE" for each item
            $totalPriceSum +=((($detail-> pro_dscont-($detail-> pro_dscont/115*100))+($detail-> pro_dscont/115*100))* $detail->quantity); // Accumulate the total price
        }
        return $totalPriceSum;
    }
    public function totalvat($id){
        $details = $this->quotation_details->qutation_details($id);
        $totalvat = 0;
       foreach($details as $detail){
           $totalvat +=($detail-> pro_dscont-($detail-> pro_dscont/115*100)); 
       }
       return $totalvat;
   }
}
?>