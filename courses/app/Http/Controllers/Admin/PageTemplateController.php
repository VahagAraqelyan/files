<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enable_work;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Route;
use Constants;
use App\Html_template;
class PageTemplateController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index(){

    }

    public function update_template(){

        $data['templates'] = Html_template::select()->get()->toArray();

        return view('admin/template/find_template',$data);
    }

    public function ax_parse_html(request $request){

        $method = $request->page;

        $data['errors'] = [];
        $data['result'] = [];

        if(empty($method)){

            $data['errors'][] = 'Please use page';
            return json_encode($data);
        }

        $template = Html_template::select()->where('title','main')->first()->toArray();

        if(empty($template)){

            $data['errors'][] = 'Page not defined';
            return json_encode($data);
        }

        $data['result'] = $template;

        return view('admin/template/page_answer',$data);
    }

    public function ax_save_page(request $request){

        $page = $request->page;
        $page_id = $request->id;

        $data['errors'] = [];

        if(empty($page_id)){

            $data['errors'][] = 'Page not found please reload page and try again';
            return json_encode($data);
        }

        if(empty($page)){
            $data['errors'][] = 'Page data  is required';
            return json_encode($data);
        }

        $template = Html_template::select()->where('id',$page_id)->first()->toArray();

        if(empty($template)){

            $data['errors'][] = 'Page not found please reload page and try again';
            return json_encode($data);
        }

        $update_data = [
            'html_template' => $page,
            'old_template' => $template['html_template'],
        ];

        Html_template::where('id',$page_id)
            ->update($update_data);

        return json_encode($data);
    }

    public function ax_revert_page(request $request){

        $page_id = $request->id;

        $data['errors'] = [];

        if(empty($page_id)){

            $data['errors'][] = 'Page not found please reload page and try again';
            return json_encode($data);
        }

        $template = Html_template::select()->where('id',$page_id)->first()->toArray();

        if(empty($template)){

            $data['errors'][] = 'Page not found please reload page and try again';
            return json_encode($data);
        }

        $update_data = [
            'html_template' => $template['old_template']
        ];

        Html_template::where('id',$page_id)
            ->update($update_data);

        return json_encode($data);
    }
}
