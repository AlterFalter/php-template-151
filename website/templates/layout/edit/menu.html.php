<div id="editMenu">
    <button onclick="siteGET('/home');" class="item"><i class="fa fa-home" aria-hidden="true"></i>Home</button>
    <button id="fileUploadButton" class="item"><i class="fa fa-cloud-upload" aria-hidden="true"></i>Upload</button>
    <input type="file" id="fileUpload" onchange="QuantityFiles();" name="fileUpload" hidden />
    <button onclick="gotoHomeFolder();" class="item"><i class="fa fa-folder" aria-hidden="true"></i>My folder</button>
    <button onclick="gotoSharedFolder();" class="item"><i class="fa fa-folder" aria-hidden="true"></i>Shared</button>
    <button onclick="siteGET('/logout');" class="item"><i class="fa fa-sign-out" aria-hidden="true"></i>Log out</button>
</div>
<div id="content">