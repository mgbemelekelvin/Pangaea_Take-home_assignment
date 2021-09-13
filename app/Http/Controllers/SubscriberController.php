<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Subscribers';
        $subs = Subscriber::whereHas('topic')->get();
        return view('subscriber.index', compact('title','subs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Subscriber';
        $topics = Auth::user()->topics;
        return view('subscriber.create', compact('title','topics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'topic_id' => 'required',
            'url' => ['required', 'unique:subscribers']
        ]);
        $topic = Topic::findOrFail($request->topic_id);
        $sub = new Subscriber();
        $sub->topic_id = $topic->id;
        $sub->url = $request->url;
        if ($sub->save()){
            return redirect('subscribers')->with('success', 'Created Successfully.');
        } else {
            return back()->with('failed','Failed something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        $title = 'Edit "'. $subscriber->url.'"';
        $topics = Auth::user()->topics;
        return view('subscriber.edit', compact('title','subscriber','topics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        $this->validate($request, [
            'topic_id' => 'required',
            'url' => [
                'required', 'string', 'max:255',
                Rule::unique('subscribers', 'url')->ignore($subscriber->url, 'url'),
            ],
        ]);
        $subscriber->topic_id = $request->topic_id;
        $subscriber->url = $request->url;
        if ($subscriber->update()){
            return back()->with('success', 'Updated Successfully.');
        } else {
            return back()->with('failed','Failed something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success','Deleted Successfully');
    }

    public function store_api(Request $request, $topic)
    {
        if ($topic) {
            //trying to fetch the topic from the database
            $topic = Topic::where('id',$topic)->first();
            if ($topic){
                //if topic exist then validate the form request
                $validator = \Validator::make($request->all(), [
                    'url' => ['required', 'unique:subscribers']
                ]);
                if ($validator->fails()) {
                    $response['status'] = 422;
                    $response['message'] = $validator->messages();
                } else {
                    $sub = new Subscriber();
                    $sub->topic_id = $topic->id;
                    $sub->url = $request->url;
                    $sub->save();
                    $response['status'] = 200;
                    $response['url'] = $request->url;
                    $response['topic'] = $topic->topic;
                }
            } else {
                $response['status'] = 422;
                $response['message'] = 'Error Cant Fetch Topic';
            }
        } else {
            $response['status'] = 422;
            $response['message'] = 'Error Cant Find Topic ID';
        }
        return response()->json($response);
    }
}
