@extends('adminlte::page')
@section('title', "Editar Página")
@section('content_header')
<h1>
    Editar Página
</h1>
@endsection
@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            <h5><i class="icon fas fa-ban">...</i>Ocorreu um erro.</h5>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card">
    <div class="card-body">
        <form action="{{route('pages.update', ['page' => $page->id])}}" method="POST" class="form-horizontal">
        @method('PUT')
        @csrf
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label"> Título</label>
                <div class="col-sm-10">
                    <input type="text" value="{{$page->title}}" name="title" id="title"
                        class="form-control @error('title') is-invalid @enderror" />
                </div>
            </div>
            <div class="form-group row">
                <label for="body" class="col-sm-2 col-form-label"> Corpo</label>
                <div class="col-sm-10">
                    <textarea name="body" class="fomr-control bodyfield" id="body">{{$page->body}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-2">
                    <input method="POST" type="submit" value="Salvar"
                        class="btn btn-success " />
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/75padcgaw5d9pji5laisashjzind8o84qulfl8btb37qdwth/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: 'textarea.bodyfield',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown autoresize',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    content_css:['{{asset('assets/css/content.css')}}'],
    images_upload_url:'{{route('imageupload')}}',
    images_upload_credentials:true,
    convert_urls:false,
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
  });
</script>
<!-- <script src="https://cdn.tiny.cloud/1/75padcgaw5d9pji5laisashjzind8o84qulfl8btb37qdwth/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector:'textarea.bodyfield',
        height:300,
        menubar:false,
        plugins:['link', 'table', 'image', 'autoresize', 'lists'],
        toolbar:'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustfy | link image | table | bullist numlist'
    });
</script> -->

@endsection
