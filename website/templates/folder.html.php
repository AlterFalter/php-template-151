<div>
    Please zip multiple files or folders, because we're only supporting the upload of one file.
</div>
<div id="folders">
    <?php 
        if (!$folder->isMainFolder)
        {
            echo '<div class="folder">
                      <button onclick="changeDirectory(0)" id="parentfolder" class="main">...</button>
                  </div>';
        }

        foreach ($folder->folders as $childfolder)
        {
            echo '<div class="folder">
                  <button onclick="changeDirectory(' . $childfolder->id . ')" class="main"><i class="fa fa-folder" aria-hidden="true"></i>' . $childfolder->name . '</button>
                  <button onclick="openFolderOverlay(' . $childfolder->id . ')" class="options"><i class="fa fa-cog" aria-hidden="true"></i></button>
                  </div>';
        }
    ?>
    <div class="folder">
        <button onclick="changeDirectory(1)" class="main"><i class="fa fa-folder" aria-hidden="true"></i>Folder a</button>
        <button onclick="openFolderOverlay(1)" class="options"><i class="fa fa-cog" aria-hidden="true"></i></button>
    </div>
    <div class="folder">
        <button onclick="changeDirectory(1)" class="main"><i class="fa fa-folder" aria-hidden="true"></i>Folder a</button>
        <button onclick="openFolderOverlay(1)" class="options"><i class="fa fa-cog" aria-hidden="true"></i></button>
    </div>
    <div class="folder">
        <button onclick="changeDirectory(1)" class="main"><i class="fa fa-folder" aria-hidden="true"></i>Folder a</button>
        <button onclick="openFolderOverlay(1)" class="options"><i class="fa fa-cog" aria-hidden="true"></i></button>
    </div>

    <div id="folderOverlay" class="overlay" hidden>
        <div class="content">
            <table>
                <tr>
                    <td><label>Rename folder: </label></td>
                    <td><input type="text" id="newFoldername" /></td>
                    <td><button onclick="renameFolder();">Rename</button></td>
                </tr>
                <tr>
                    <td><label>Delete folder: </label></td>
                    <td colspan="2"><button onclick="renameFolder();">Delete</button></td>
                </tr>
                <tr>
                    <td><label>Relocate folder: </label></td>
                    <td>
                        <select type="text" id="" >
                            <option value="">Parent folder</option>
                            <option value="<?php echo "error" ?>"><?php echo "error" ?></option>
                        </select>
                    </td>
                    <td><button onclick="renameFolder();">Relocate</button></td>
                </tr>
            </table>
            <button onclick="closeFolderOverlay();">Close</button>
        </div>
    </div>
</div>
<div id="files">
    <?php
        foreach ($folder->files as $file)
        {
            echo '<div class="file">
                  <button onclick="downloadFile(1)" class="main"><i class="fa fa-file" aria-hidden="true"></i>File a</button>
                  <button onclick="openFileOverlay(1)" class="options"><i class="fa fa-cog" aria-hidden="true"></i></button>
                  </div>';
        }
    ?>
    
    <div class="file">
        <button onclick="downloadFile(2)" class="main"><i class="fa fa-file" aria-hidden="true"></i>File a</button>
        <button onclick="openFileOverlay(2)" class="options"><i class="fa fa-cog" aria-hidden="true"></i></button>
    </div>
    <div class="file">
        <button onclick="downloadFile(3)" class="main"><i class="fa fa-file" aria-hidden="true"></i>File a</button>
        <button onclick="openFileOverlay(3)" class="options"><i class="fa fa-cog" aria-hidden="true"></i></button>
    </div>
    <div class="file">
        <button onclick="downloadFile(4)" class="main"><i class="fa fa-file" aria-hidden="true"></i>File a</button>
        <button onclick="openFileOverlay(4)" class="options"><i class="fa fa-cog" aria-hidden="true"></i></button>
    </div>
    <div class="file">
        <button onclick="downloadFile(5)" class="main"><i class="fa fa-file" aria-hidden="true"></i>File a</button>
        <button onclick="openFileOverlay(5)" class="options"><i class="fa fa-cog" aria-hidden="true"></i></button>
    </div>

    <div id="fileOverlay" class="overlay" hidden>
        <div class="content">
            <table>
                <tr>
                    <td><label>Rename file: </label></td>
                    <td><input type="text" id="newFilename" name="newFilename" /></td>
                    <td><button onclick="renameFile();">Rename</button></td>
                </tr>
                <tr>
                    <td><label>Delete file: </label></td>
                    <td colspan="2"><button onclick="deleteFile();">Delete</button></td>
                </tr>
                <tr>
                    <td><label>Relocate file: </label></td>
                    <td>
                        <select type="text" id="" >
                            <option value="">Parent file</option>
                            <option value="<?php echo "error" ?>"><?php echo "error" ?></option>
                        </select>
                    </td>
                    <td><button onclick="relocateFile();">Relocate</button></td>
                </tr>
                <tr>
                    <td><label>Share: </label></td>
                    <td><input type="text" id="newFilename" name="newFilename" /></td>
                    <td><button onclick="renameFile();">Relocate</button></td>
                </tr>
            </table>
            <button onclick="closeFileOverlay();">Close</button>
        <div>
    </div>
</div>


