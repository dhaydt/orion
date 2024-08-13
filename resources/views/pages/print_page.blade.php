@extends('layouts.app')
@section('content')
<style>
  .container {
    max-width: 600px;
  }

  #print {
    padding: 10px;
    border-radius: 0.375rem;
    text-align: center;
    cursor: pointer;
  }

</style>
<div>
  @livewire('print-page', ['id' => $id])
</div>
@endsection