<form method="post" action="?p=user&a=add_assignment_blog_post">
   <input type="hidden" name="assignment_id" value="<?php echo $_GET['assignment_id']; ?>" />
   <input type="text" name="url" placeholder="URL til bloggpost" />
   <textarea name="note" placeholder="Beskrivelse av besvarelse"></textarea>
   <input type="submit" value="Lever">
</form>
