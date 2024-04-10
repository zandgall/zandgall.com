<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    11/22 - Deciding what to make, envisioning what it would look and act like. (Step 0)
    11/23 - Started presentation. (Step 1) (Thanksgiving!)
    11/24 - Explained JSON approach with example data. Added links.
 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentation</title>
</head>
<body>
    <header style="text-align:center">
        <a href="./" style="margin:1mm">User View</a>
        <a href="presentation" style="margin:1mm">Home</a>
        <a href="edit" style="margin:1mm">Edit Page</a>
        <a href="resetData" style="margin:1mm">Reset Data</a>
    </header>
    <main>
        <section>
            <h1>Questions:</h1>
            <h2>Can you give a general description of the web app?</h2>
            <p>A tool that can be used by Students and Professors to manage assignments with due dates.</p>
            <h2>Who is the target demographic of the application?</h2>
            <p>Students. I want the focus to be on students tracking their work and keeping up with due dates.</p>
            <h2>What will be tracked by students?</h2>
            <p>Students will track their schoolwork assignments from all enrolled classes. They will be able to mark their personal progress on assignments.</p>
            <h2>What will be tracked by professors?</h2>
            <p>Professors will modify their classes, which updates students. Assignments will be automatically updated so that the student can see assignments due soon.</p>
            <h2>Why?</h2>
            <p>The purpose and almost 'gimmick' of this website is to simplify the Students and possibly Professor's view of assignments, by delivering to the Students a simple stream of assignments due. Making it easier to keep track of assignments, and near impossible to forget to do something before it's due.</p>
        </section>
        <section>
            <table border='1'>
                <thead>
                    <caption>Classes</caption>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Color</th>
                        <th>List of Assignments</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>                        
                        <td>CSC235</td>
                        <td>Server Side Development</td>
                        <td>#4287f5</td>
                        <td>...</td>
                    </tr>
                    <tr>
                        <td>MAT255</td>
                        <td>Calculus III</td>
                        <td>#f56f42</td>
                        <td>...</td>
                    </tr>
                </tbody>
            </table>
            <table border='1'>
                <thead>
                    <caption>Assignments</caption>
                    <tr>
                        <th>Class</th>
                        <th>Index</th>
                        <th>Name</th>
                        <th>Due Date</th>
                        <th>Steps (optional)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>0</td>
                        <td>Week 4 Individual Assignment</td>
                        <td>CSC235</td>
                        <td>- Think of a project<br>- Needs assessment (presentation.php)<br>- Problem Analysis<br>- Proof-of-Concept Code<br>- Prototype the UI<br>- Write the App<br>- Publish to the Server</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1</td>
                        <td>Week 4 Term Project</td>
                        <td>CSC235</td>
                        <td>- Create Form</td>
                    </tr>
                </tbody>
            </table>
            <table border='1'>
                <thead>
                    <caption>Users</caption>
                    <tr>
                        <th>Username</th>
                        <th>Enrolled Classes</th>
                        <th>Assignments progress</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>galla</td>
                        <td>1, 2</td>
                        <td>1[0](true, true, true, false, false, false, false), 1[1](false)</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section>
            <h1>Data Approach</h1>
            <p>I will waste no time trying to construct a SQL database design for this data. This data is far too hierarchical. A good way to store this kind of data would be in a JSON file.</p>
            <p><pre>
{
    "classes": {
        "csc235": {
            "name": "Server-Side Development",
            "color": "#4287f5",
            "assignments": [
                {
                    "name": "Week 4 Individual Project",
                    "due": 1701064799,
                    "steps": [
                        "Think of a project",
                        "Needs Assessment",
                        "Problem Analysis",
                        "Proof-Of-Concept",
                        "Prototype the UI",
                        "Write the App",
                        "Publish to the Server"
                    ]
                },
                {
                    "name": "Week 4 Term Project",
                    "due": 1701064799,
                    "steps": [
                        "Create Web Form"
                    ]
                }
            ]
        },
        "mat255": {
            "name": "Calculus III",
            "color": "#f56f42",
            "assignments": [
                { 
                    "name": "Homework 5.6 Calculating Centers of Mass and Moments of Inertia",
                    "due": 1701151199
                }
            ]
        }
    },
    "students": {
        "galla": {
            "enrolled-classes": {
                "CSC235": {
                    "grade": "something",
                    "attendance": "something",
                    "assignment-progress": [
                        {
                            "comment": "Assignments are a fixed array. Index 0 of 'enrolled-classes.csc235.assignment-progress' matches index 0 of 'classes.csc235.assignments'. Which means this is for Week 4 Individual Assignment",
                            "done": false,
                            "steps": [
                                true, true, true, false, false, false, false
                            ]
                        },
                        {
                            "done": false,
                            "steps": [
                                false
                            ]
                        }
                    ]
                },
                "MAT255": {
                    "grade": "something",
                    "attendance": "something",
                    "assignment-progress": [
                        {
                            "done": false
                        }
                    ]
                }
            }
        }
    }
}
            </pre></p>
            <p>This data can then be read and modified by PHP code, with post requests from forms or JavaScript.</p>
        </section>
        <section>
            <img src="prototype.png" style="width:80%"/>
        </section>
    </main>
</body>
</html>