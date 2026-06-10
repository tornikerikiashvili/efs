<!-- Create the editor container -->
<div id="editoridentifier-{{$inputname}}" class="quilcustomeditor">
    <div id="editor-{{$inputname}}">{!!$content!!}</div>
    <textarea name="{{$inputname}}" style="display:none" id="hiddenArea-{{$inputname}}">{{$content}}</textarea>
</div>
<script>quillEditorInput('{{$inputname}}')</script>