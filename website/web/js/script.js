/* generally */
window.onload = function()
{
    changeUploadButtonSize();
}
window.onresize = function()
{
    changeUploadButtonSize();
}
$(document).ready(function() {
  $('#fileUploadButton').click(function(){
    $("#fileUpload").click();
  });
});
function siteGET(url)
{
    window.location.replace(url);
}
function sitePOST(url)
{
    $.post(url);
}
function loadPartial(url)
{
    // remove old content
    $("#content").html("");
    // post site
    $('#divname').load(url);
}
/* main */
//--------

/* drive */
function changeUploadButtonSize()
{
    var newWidth = $("#content").width() - 20;
    $("#uploadFilesButton").width(newWidth);
    
}
function upload()
{
    $.ajax({
        type: "POST",
        url: "~/Drive/Upload",
        data: data,
        success: success,
        dataType: dataType
    });
}
/* Folder */
var actualFolderId;
function changeDirectory(folderId)
{
    siteGET("/drive?folderId=" + folderId);
}
function gotoHomeFolder()
{
    changeDirectory(0);
}
function gotoSharedFolder()
{
    changeDirectory(-1);
}

function openFolderOverlay(id)
{
    closeFolderOverlay();
    closeFileOverlay();
    actualFolderId = id;
    // disable scrolling
    document.body.style.overflow = 'hidden';
    // show overlay
    $("#folderOverlay").show();
}
function closeFolderOverlay()
{
    $("#folderOverlay").hide();
}
function renameFolder()
{
    // get folder id
    
    // get new name
    
    // start request
}
function deleteFolder()
{
    // get folder id
    
    // start request
    
}
function relocateFolder()
{
    // get folder id
    
    // get parent folder id
    
    // start request
    
}
/* File */
var actualFileId = 0;
function openFileOverlay(id)
{
    console.log("logged" + id + $("#fileOverlay"));
    closeFolderOverlay();
    closeFileOverlay();
    actualFileId = id;
    // disable scrolling
    document.body.style.overflow = 'hidden';
    // show overlay
    $("#fileOverlay").show();
}
function closeFileOverlay(id)
{
    $("#fileOverlay").hide();
}

function downloadFile(fileId)
{
    console.log("download file");
    // https://stackoverflow.com/questions/19851782/
    var newWindow = window.open("/download?fileId=" + fileId, "_blank");
    if (newWindow)
    {
        newWindow.focus();
    }
    else
    {
        alert("Please allow popups for this website");
    }
}

function renameFile()
{
    // get folder id
    
    // get new name
    
    // start request
}
function deleteFile()
{
    // get folder id
    
    // start request
    
}
function relocateFile()
{
    // get folder id
    
    // get parent folder id
    
    // start request
    
}
