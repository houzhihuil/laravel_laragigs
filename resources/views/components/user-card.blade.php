@props(['user'])
 
    <div class="bg-gray-50 border border-gray-200 rounded p-6">
        <div class="flex">
           <img class="hidden w-48 mr-6 md:block" 
           src="/images/logo.png" alt=""  /> 
        <div>
               <h3 class="text-2xl">
                <a href="/users/{{$user->id}}">User Id: {{$user->id}}</a> 
               </h3>
               <div class="text-xl font-bold mb-4">{{$user->name}}</div>
               <ul class="flex">
                   <li
                       class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
                   >
                       <a href="#">{{$user->email}}</a>
                   </li> 
               </ul>
             
           </div>
       </div>  
    </div> 
 
 