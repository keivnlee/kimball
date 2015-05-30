/**
 * Created by lizhimin on 3/23/15.
 */

function toggle_job_detail_items(id)
{
    id.style.display='block';
    //
}

// disable all the detail class except specific div.
function showActiveSection(id)
{
    var sections = document.getElementsByClassName("detail");
    for(var i = 0; i < sections.length; i++)
        sections[i].style.display = 'none';
    id.style.display = 'block';
}

// disable the form div
function cancle()
{
    document.getElementById('content').style.display = "none";
}

//job form submit
function update_job_form()
{
    //get the submit button
    var isSubmit = window.confirm("Do you want to submit the data?");
    if(isSubmit == true)
        $.ajax({
            type: "POST",
            url: "job_form_data_update.php",
            data: $("#job_form").serialize(),
            success: function() {
                //TODO: give feedback tell user the update success.
                window.alert('success');
                cancle();
            }
        });
}

//serviceIssueJob form submit
function update_serviceIssueJob_form()
{
    //get the submit buttion
    var isSubmit = window.confirm("Do you want to submit the data?");
    if(isSubmit == true)
        $.ajax({
            type: "POST",
            url: "serviceIssueJob_form_dataupdate.php",
            data: $("#serviceIssueJob_form").serialize(),
            success: function() {
                //TODO: give feedback tell user the update success.
                window.alert('success');
                cancle();
            }
        });
}

//serviceIssue form submit
function update_serviceIssue_form()
{
    //get the submit buttion
    var isSubmit = window.confirm("Do you want to submit the data?");
    if(isSubmit == true)
        $.ajax({
            type: "POST",
            url: "serviceIssue_form_dataupdate.php",
            data: $("#serviceIssue_form").serialize(),
            success: function() {
                //TODO: give feedback tell user the update success.
                window.alert('success');
                cancle();
            }
        });
}

// load job section
function load_job_table(page) {
    showActiveSection(job_detail_jobs);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            job_table.innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "job_table.php?search="+job_searchBar.value+"&page="+page, true);
    xmlhttp.send();
}

function load_serviceIssueJob_table(page) {
    showActiveSection(serviceIssueJobs_detail);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
            serviceIssueJobs_table.innerHTML = xmlhttp.responseText;
    }
    xmlhttp.open("GET", "serviceIssueJob_table.php?page="+page+"&search="+serviceIssueJobs_searchBar.value, true);
    xmlhttp.send();
}

function load_serviceIssue_table(page) {
    showActiveSection(serviceIssue_detail);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
            serviceIssue_table.innerHTML = xmlhttp.responseText;
    }
    xmlhttp.open("GET", "serviceIssue_table.php?page="+page+"&search="+serviceIssue_searchBar.value, true);
    xmlhttp.send();
}

// return the detail form of job
// it1  job_no
// it   cust_no
function load_job_form(it1, it2)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("contentform").innerHTML = xmlhttp.responseText;
            tab_select("view1",'li1');
        }
    }

    xmlhttp.open("GET", "job_form.php?job_no="+it1+"&cust_no="+it2, true);
    xmlhttp.send();
    document.getElementById('content').style.display = "block";
}

//para1 Model
//para2 serialNo
//para3 SI
//para4 ServiceNotes
function load_serviceIssue_form(para1, para2, para3)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("contentform").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "serviceIssue_form.php?SI="+para1+
    "&IR1="+para2+"&IR2="+para3, true);
    xmlhttp.send();
    document.getElementById('content').style.display = "block";
}

//para1 jobid
function load_serviceIssueJob_form(para1)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("contentform").innerHTML = xmlhttp.responseText;
            tab_select("view1",'li1');
        }
    }
    xmlhttp.open("GET", "serviceIssueJob_form.php?job_no="+para1, true);
    xmlhttp.send();
    document.getElementById('content').style.display = "block";

}

function tab_select(index, tab){
    var section = document.getElementsByClassName("tab_index");
    for(var i = 0; i < section.length; i++)
        section[i].style.background = '';
    document.getElementById(tab).style.background = "White";

    var sections = document.getElementsByClassName("tab");
    for(var i = 0; i < sections.length; i++)
        sections[i].style.display = 'none';
    document.getElementById(index).style.display="block";
}

//file upload function
function upload(table, attribute, job_no, cust_no)
{
    var client = new XMLHttpRequest();
    var file = document.getElementById(attribute);
    var fileuploadsection = document.getElementById(attribute.concat("section"));
    //check whether the file is empty?
    if(file.files.length == 0)
    {
        alert("Please choose a pdf file");
        return;
    }
    var filepath = file.value.split("\\");
    var filename = filepath[filepath.length-1];
    filename = filename.replace(/ /g,'');
    /* Create a FormData Instance*/
    var formData = new FormData();
    /* Add the file*/
    formData.append('fileToUpload', file.files[0]);
    formData.append('table', table);
    formData.append('attribute', attribute);
    formData.append('job_no', job_no);
    formData.append('cust_no', cust_no);

    client.open('post','upload.php', true);
    //client.setRequestHeader("Content-Type", "multipart/form-data");
    client.send(formData);/* Send to server*/

    /* Check the response status*/
    client.onreadystatechange = function()
    {
        if(client.readyState == 4 && client.status == 200)
        {
            alert(client.responseText);
            //change the current statue of the file upload bar.
            fileuploadsection.innerHTML="<img src='http://www.utvmedia.com/images/layout/PDF_icon_homepage.gif'><a href='"+"uploads/"+filename+"' target='_blank'>"+filename+"</a>&nbsp;&nbsp;<a href='#' onclick=deleteFile('job','"+attribute+"','"+job_no+"','"+cust_no+"')>delete</a><br>";
        }
    }


}

//file delete function
function deleteFile(table, attribute, job_no, cust_no)
{
    var res = window.confirm("You want to delete this file?");
    if(res ==  true){
        //update the database
        var client = new XMLHttpRequest();
        var fileuploadsection = document.getElementById(attribute.concat("section"));
        /* Create a FormData Instance*/
        var formData = new FormData();
        /* Add the file*/
        formData.append('table', table);
        formData.append('attribute', attribute);
        formData.append('job_no', job_no);
        formData.append('cust_no', cust_no);
        client.open('post','file_delete.php', true);
        //client.setRequestHeader("Content-Type", "multipart/form-data");
        client.send(formData);/* Send to server*/
        /* Check the response status*/
        client.onreadystatechange = function(){
            if(client.readyState == 4 && client.status == 200){
                fileuploadsection.innerHTML="<input type='file' id='"+attribute+"' name='fileToUpload'><input type='button' value='upload' onclick = upload('job','"+attribute+"','"+job_no+"','"+cust_no+"')>";
            }
        }
    }
    else//do nothing
        return;
}

function changeHappen(id)
{
    id.value = true;
}

