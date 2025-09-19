
@component('mail::message')
<div style="text-align: center; margin-bottom: 20px;">
    @if(file_exists(public_path('image/logo.png')))
        <img src="{{ $message->embed(public_path('image/logo.png')) }}" 
             alt="{{ config('app.name') }} Logo" 
             style="max-height: 80px;">
    @else
        <h2 style="color: #333; margin: 0;">{{ config('app.name') }}</h2>
    @endif
</div>

# 📋 New Task Assignment  
You have a new task to complete  

Hello {{ $assignee->name ?? 'Team Member' }},  

You've been assigned the following task:  

Task Title: {{ $task->title ?? 'New Task' }}  

@if(!empty($task->description))
Description:  
{{ $task->description }}  
@endif

@if(!empty($task->due_date))
Due Date: 📅 {{ \Carbon\Carbon::parse($task->due_date)->format('F j, Y') }} ({{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }})
@endif

@if(!empty($task->priority))
Priority: {{ $task->priority->name ?? 'Medium' }} Priority  
@endif

@if(!empty($task->status))
Status: {{ ucfirst($task->status) }}  
@endif

@if(!empty($task->created_by))
Assigned by: {{ $task->creator->name }}  
@endif

@component('mail::button', ['url' => route('tasks.show', $task->id)])
View Task Details
@endcomponent

---  


<small style="color: #999; display: block; margin-top: 10px;">
© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
</small>
@endcomponent