// Function to get URL parameters
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Check for error parameter in URL
const stat = getUrlParameter('stat');

if (stat) {
    let message = '';
    let title = 'Error';
    let icon = 'error';
    switch (stat) {
        case 'invaliduserid':
            message = 'User ID must be between U001 and U999.';
            break;
        case 'invalidusername':
            message = 'Invalid username. Only letters and numbers are allowed.';
            break;
        case 'invalidemail':
            message = 'Invalid email address.';
            break;
        case 'usernametaken':
            message = 'Username or email already taken.';
            break;
        case 'invalidpwd':
            message = 'password must be more than 8 characters.';
            break;
        case 'stmtfailed':
            message = 'Something went wrong. Please try again.';
            break;
        case 'Already_Exists':
            message = 'Account already exists.';
            break;
        case 'none':
            title = 'Account Creation Saved Successfully.';
            message = 'Welcome to the Library management system';
            icon = 'success';
            break;
        case 'nouser':
            message = 'User does not exist.';
            break;
        case 'wrongpwd':
            message = 'Wrong password.';
            break;
        case 'success':
            title = 'Login successfully';
            message = 'Welcome Back';
            icon = 'success';
            break;
        case 'logout':
            title = 'You have been logged out successfully.';
            message = 'See You Again.';
            icon = 'success';
            break;
        case 'Deleted':
            title = 'User Account Deleted Successfully.';
            message = '';
            icon = 'success';
            break;
        case 'Updated_successfully':
            title = 'User Account Updated Successfully.';
            message = '';
            icon = 'success';
            break;
        default:none
        
    }
    swal(title, message, icon);
}
