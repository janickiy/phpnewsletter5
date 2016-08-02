<?php

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_edit_template extends Model
{
    public function editTemplate($fields, $id_template)
    {
        if (is_numeric($id_template)) {

           $result = core::database()->update($fields, core::database()->getTableName('template'), "id_template = " . $id_template);

           if ($result) {
               for ($i = 0; $i < count($_FILES["attachfile"]["name"]); $i++) {
                   if (!empty($_FILES["attachfile"]["name"][$i])) {
                       $ext = strrchr($_FILES['attachfile']['name'][$i], ".");
                       $attachfile = $PNSL["system"]["dir_attach"] . date("YmdHis", time()) . $i . $ext;

                       if (@copy($_FILES['attachfile']['tmp_name'][$i], $attachfile)) {
                           @unlink($_FILES['attachfile']['tmp_name'][$i]);
                       }

                       $attachfields = array();
                       $attachfields['id_attachment'] = 0;
                       $attachfields['name'] = $_FILES['attachfile']['name'][$i];
                       $attachfields['path'] = $attachfile;
                       $attachfields['id_template'] = $id_template;

                       core::database()->insert($attachfields, core::database()->getTableName('attach'));
                   }
               }

               return true;
           } else return false;
       }
    }

    public function getAttachmentsList($id_template)
    {
        $query = "SELECT * FROM " . core::database()->getTableName('attach') . " WHERE id_template=" . $id_template . " ORDER by name";
        $result = core::database()->querySQL($query);

        return core::database()->getColumnArray($result);
    }

    public function getCategoryOptionList()
    {
        $query = "SELECT * FROM " . core::database()->getTableName('category') . " ORDER by name";
        $result = core::database()->querySQL($query);

        return core::database()->getColumnArray($result);
    }

    public function getTemplate($id_template)
    {
        if (is_numeric($id_template)) {
            $query = "SELECT * FROM " . core::database()->getTableName('template') . " WHERE id_template=" . $id_template;
            $result = core::database()->querySQL($query);

            return core::database()->getRow($result);
        }
    }

    public function removeAttach($id_attachment)
    {
        if (is_numeric($id_attachment)) {
            $query = "SELECT * FROM " . core::database()->getTableName('attach') . " WHERE id_attachment=" . $id_attachment;
            $result = core::database()->querySQL($query);

            while ($row = core::database()->getRow($result, 'array')) {
                if (file_exists($row['path'])) @unlink($row['path']);
            }

            return core::database()->delete(core::database()->getTableName('attach'), "id_attachment=" . $id_attachment, '');
        }
    }
}