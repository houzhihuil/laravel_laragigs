<?php
  
  namespace App\Http\Controllers;
     
  use App\Models\Listing;
  use App\Models\User;
  use Illuminate\Http\Request;
  use Illuminate\Validation\Rule; 
    
  class ListingController extends Controller
  {
      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
 
      public function index()
        {
            // dd(filter('tag'));
            return view('listings.index', [
                'listings' => Listing::oldest()
                    ->filter(request(['tag', 'search']))
                    ->paginate(4)
            ]);
        } 

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create()
      {
          return view('listings.create');
      }
      
      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(Request $request)
      {
            $formFields= $request->validate([
                'title'=> 'required',
                'location'=> 'required',
                'company'=> ['required', Rule::unique('listings','company')],
                'email' => ['required','email'],
                'website'=> 'required',   
                'tags'=> 'required',
                'description'=> 'required'
          ]);

          $formFields['user_id'] = auth()->id();

          if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos','public');
          }
          //
          Listing::create($formFields);
       
          return redirect()->route('listings.index')
                          ->with('success','Listing created successfully.');
      }
       
      /**
       * Display the specified resource.
       *
       * @param  \App\Listing  $listing
       * @return \Illuminate\Http\Response
       */
      public function show(Listing $listing)
      {
          return view('listings.show',compact('listing'));
      } 
       
      /**
       * Show the form for editing the specified resource.
       *
       * @param  \App\Listing  $listing
       * @return \Illuminate\Http\Response
       */
      public function edit(Listing $listing)
      {
          /* return view('listings.edit',compact('listing')); */
          /* dd($listing->title); */
          return view('listings.edit',['listing' => $listing]);
      }
      
      /**
       * Update the specified resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  \App\Listing  $listing
       * @return \Illuminate\Http\Response
       */
      public function update(Request $request, Listing $listing)
      {
/*         if($listing ->user_id != auth()->id){
          abort(403,'Unauthorized Action');
        } */
/*         if ($listing->user_id != auth()->id()) {
          return redirect()->route('listings.index')
                          ->with('error', 'You are not authorized to modify this listing.');
      } */
//
// Debugging code to print out $listing and auth()->id()
// dd($listing, auth()->id());

        if ($listing->user_id != auth()->id()) {
          return redirect()->route('listings.index')
                          ->with('error', 'Unauthorized action');
        }

        $formFields= $request->validate([
         
            'title'=> 'required',
            'location'=> 'required',
            'company'=>  'required',
            'email' => ['required','email'],
            'website'=> 'required',   
            'tags'=> 'required',
            'description'=> 'required'
          ]);
          
          if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos','public');
          }

          $listing->update($formFields);
      
          return redirect()->route('listings.index')
                          ->with('success','Listing updated successfully');
      }
      
      /**
       * Remove the specified resource from storage.
       *
       * @param  \App\Listing  $listing
       * @return \Illuminate\Http\Response
       */
      public function destroy(Listing $listing)
      {
          $listing->delete();
      
          return redirect()->route('listings.index')
                          ->with('success','Listing deleted successfully');
      }
      //   Manage Listings 
      public function manage(){  
         return view('listings.manage', ['listings' => auth()->user()->listings]); 
    } 


  }
  ?>