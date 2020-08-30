<?php

namespace App\Http\Controllers;

use App\User;
use App\ExpenseReport;

//anexar estos namespaces por la funcion sendMail
use App\Mail\SummaryReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;



class ExpenseReportController extends Controller
{

    //Para proteger nuestras rutas vamos agregar lo siguiente:
    public function __construct()
    {
        $this->middleware('auth');
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //me voy a traer todos los elementos
        return view('expenseReport.index', [

            //Para mostrar solo los resultados del usuario logeado uso Where
        
            'expenseReports' => ExpenseReport::where('user_id', Auth::user()->id)->get(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('expenseReport.create');
       


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Esto me sirve para cuando envío información
        //Obtener los valores que necesitamos
        //En el método Get se coloca lo que va en el name del form
        //La funcion Redirect me direcciona a un view

         // vamos a realizar validaciones en la vista create

        $validData = $request->validate([
            'title' => 'required|min:3'
        ]);

        $report = new ExpenseReport();
        $report->title = $validData['title'];

        //ahora vamos a relacionar el otro ID
        
        $report->user_id = Auth::user()->id;
        
        

        $report->save();

        return redirect('/expense_reports');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseReport $expenseReport)
    {
        //despliega la información precisa para un recursos dado
        //puedo mostrar información de reportes

        //Model Binding=se define en vez del findOrFail $report = ExpenseReport::findOrFail($id);

        return view ('expenseReport.show', [
            'report' => $expenseReport
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Para editar hay el metodo Find
        //Si en la URL pongo: /expense_reports/30/edit no estoy validando que los reportes existan para hacer eso uso un if
        //para usar el if y verificar si exite coloco el método: findOrFail
        
      


        $report = ExpenseReport::findOrFail($id);
        return view ('expenseReport.edit', [
            'report' => $report
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Para validar las respuestas

        $validData = $request->validate([
            'title' => 'required|min:3'
        ]);

        //sirve para el método de editar
        $report = ExpenseReport::findOrFail($id); //para encontrar el id inicial
        $report->title = $request->get('title');
        $report->save();

        return redirect('/expense_reports');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //copio lo de update
        //destroy permite destruir varios ides de modelos: $report->destroy(); 
        $report = ExpenseReport::findOrFail($id); //para encontrar el id inicial
        $report->delete();

        return redirect('/expense_reports');


    }

    public function confirmDelete($id){
        $report = ExpenseReport::findOrFail($id);

        return view('expenseReport.confirmDelete',[
            'report' => $report
        ]);
    }

    public function confirmSendMail($id){

        //primero obtenemos el reporte

        $report = ExpenseReport::findOrFail($id);

        return view('expenseReport.confirmSendMail',[
            'report' => $report
        ]);
    }

    public function sendMail(Request $request, $id){
        $report = ExpenseReport::findOrFail($id);
        Mail::to($request->get('email'))->send(new SummaryReport($report));

       

        return redirect('/expense_reports/' . $id);


    }

}