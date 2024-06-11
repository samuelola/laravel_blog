
<div class="form-group">
    <label for="">Title</label>
    <input type="text" name="title" class="form-control" value="{{old('title',$post->title ?? null)}}"/>
</div>
    
<div class="form-group">
    <label for="">Content</label>
    <textarea class="form-control" name="content">{{old('content',$post->content ?? null)}}</textarea>
</div>

<div class="form-group">
    <label for="">Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control-file"/>
</div>


     