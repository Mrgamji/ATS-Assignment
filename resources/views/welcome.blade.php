<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Management API Documentation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #6c63ff;
      --secondary-color: #4d44db;
      --dark-color: #2a2a72;
      --light-color: #f8f9fa;
      --success-color: #28a745;
      --info-color: #17a2b8;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7ff;
      color: #333;
      line-height: 1.6;
    }
    
    .container {
      max-width: 1200px;
    }
    
    .header {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      padding: 2rem 0;
      border-radius: 0 0 20px 20px;
      margin-bottom: 2rem;
      box-shadow: 0 4px 20px rgba(108, 99, 255, 0.2);
    }
    
    .api-section {
      background: white;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
      border-left: 4px solid var(--primary-color);
    }
    
    .endpoint-card {
      border: 1px solid #e1e1e1;
      border-radius: 8px;
      margin-bottom: 1.5rem;
      overflow: hidden;
    }
    
    .endpoint-header {
      background-color: var(--light-color);
      padding: 0.75rem 1.25rem;
      border-bottom: 1px solid #e1e1e1;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    .method {
      font-weight: bold;
      padding: 0.25rem 0.75rem;
      border-radius: 4px;
      font-size: 0.8rem;
      text-transform: uppercase;
      color: white;
    }
    
    .method.get { background-color: var(--success-color); }
    .method.post { background-color: var(--info-color); }
    .method.put { background-color: #ffc107; }
    .method.delete { background-color: #dc3545; }
    
    .endpoint-body {
      padding: 1.25rem;
    }
    
    .endpoint-url {
      font-family: 'Courier New', monospace;
      background-color: #f8f9fa;
      padding: 0.5rem;
      border-radius: 4px;
      word-break: break-all;
    }
    
    pre {
      background-color: #f8f9fa;
      padding: 1rem;
      border-radius: 8px;
      border: 1px solid #e1e1e1;
      overflow-x: auto;
    }
    
    code {
      font-family: 'Courier New', monospace;
      font-size: 0.9rem;
      color: #d63384;
    }
    
    .tab-content {
      padding: 1rem 0;
    }
    
    .nav-tabs .nav-link {
      color: #495057;
      font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
      color: var(--primary-color);
      border-bottom: 2px solid var(--primary-color);
    }
    
    .badge-auth {
      background-color: var(--dark-color);
      font-size: 0.7rem;
      vertical-align: middle;
    }
    
    .example-request {
      position: relative;
    }
    
    .copy-btn {
      position: absolute;
      right: 10px;
      top: 10px;
      background: rgba(255,255,255,0.8);
      border: none;
      border-radius: 4px;
      padding: 0.25rem 0.5rem;
      cursor: pointer;
      font-size: 0.8rem;
    }
    
    .copy-btn:hover {
      background: white;
    }
    
    .feature-icon {
      font-size: 1.5rem;
      color: var(--primary-color);
      margin-right: 0.5rem;
    }
    
    .quick-nav {
      position: sticky;
      top: 20px;
    }
    
    .quick-nav .list-group-item {
      border: none;
      padding: 0.5rem 1rem;
      color: #495057;
    }
    
    .quick-nav .list-group-item:hover {
      color: var(--primary-color);
      background-color: rgba(108, 99, 255, 0.1);
    }
    
    .quick-nav .list-group-item.active {
      color: white;
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }
    
    .response-schema {
      margin-top: 1rem;
    }
    
    .response-schema h6 {
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .auth-required {
      display: inline-block;
      margin-left: 0.5rem;
    }
  </style>
</head>
<body>
  <div class="header text-center">
    <div class="container">
      <!-- ADD BY Ahmad Muhammad Salisu -->
      <h1><i class="fas fa-calendar-alt me-2"></i> ATS Event Management API</h1>
      <p class="lead">Powerful REST API for managing events with JWT authentication</p>
      <p class="lead">by Ahmad Muhammad Salisu</p>
      <div class="d-flex justify-content-center gap-3 mt-3">
        <a href="#authentication" class="btn btn-light btn-sm">Authentication</a>
        <a href="#events" class="btn btn-light btn-sm">Events</a>
        <a href="#testing" class="btn btn-light btn-sm">Testing</a>
        <a href="#environment" class="btn btn-light btn-sm">Environment</a>
      </div>
      <!-- END ADD BY Ahmad Muhammad Salisu -->
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <section id="introduction" class="api-section">
          <h2><i class="fas fa-info-circle feature-icon"></i> Introduction</h2>
          <p>This API provides complete functionality for managing events in a secure environment. Built with Laravel and using JWT authentication, it allows you to:</p>
          <ul>
            <li>Register and authenticate users</li>
            <li>Create, read, update, and delete events</li>
            <li>Manage event details including title, description, location, and timing</li>
            <li>Secure all endpoints with JWT tokens</li>
          </ul>
          <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> All protected endpoints require a valid JWT token in the <code>Authorization</code> header.
          </div>
        </section>

        <section id="authentication" class="api-section">
          <h2><i class="fas fa-lock feature-icon"></i> Authentication</h2>
          <p>All authentication endpoints are publicly accessible. After authentication, you'll receive a JWT token that must be included in subsequent requests.</p>
          
          <div class="endpoint-card">
            <div class="endpoint-header">
              <span class="method post">POST</span>
              <span class="endpoint-url">/api/register</span>
              <span class="badge bg-success">Public</span>
            </div>
            <div class="endpoint-body">
              <h5>Register a new user</h5>
              <p>Creates a new user account and returns a JWT token for immediate authentication.</p>
              
              <ul class="nav nav-tabs" id="registerTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="register-request-tab" data-bs-toggle="tab" data-bs-target="#register-request" type="button" role="tab">Request</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="register-response-tab" data-bs-toggle="tab" data-bs-target="#register-response" type="button" role="tab">Response</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="register-curl-tab" data-bs-toggle="tab" data-bs-target="#register-curl" type="button" role="tab">cURL</button>
                </li>
              </ul>
              
              <div class="tab-content">
                <div class="tab-pane fade show active" id="register-request" role="tabpanel">
                  <div class="example-request">
                    <button class="copy-btn" onclick="copyToClipboard('register-request-code')"><i class="far fa-copy"></i> Copy</button>
                    <pre id="register-request-code"><code>{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "08012345678",
  "password": "secret123",
  "password_confirmation": "secret123"
}</code></pre>
                  </div>
                </div>
                <div class="tab-pane fade" id="register-response" role="tabpanel">
                  <div class="example-request">
                    <button class="copy-btn" onclick="copyToClipboard('register-response-code')"><i class="far fa-copy"></i> Copy</button>
                    <pre id="register-response-code"><code>{
  "message": "Registration successful",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "08012345678",
    "updated_at": "2023-07-15T12:34:56.000000Z",
    "created_at": "2023-07-15T12:34:56.000000Z"
  }
}</code></pre>
                  </div>
                </div>
                <div class="tab-pane fade" id="register-curl" role="tabpanel">
                  <div class="example-request">
                    <button class="copy-btn" onclick="copyToClipboard('register-curl-code')"><i class="far fa-copy"></i> Copy</button>
                    <pre id="register-curl-code"><code>curl -X POST \
  http://atsassignment.up.railway.app/api/register \
  -H 'Content-Type: application/json' \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "08012345678",
    "password": "secret123",
    "password_confirmation": "secret123"
  }'</code></pre>
                  </div>
                </div>
              </div>
              
              <div class="response-schema">
                <h6>Request Parameters</h6>
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th>Field</th>
                      <th>Type</th>
                      <th>Required</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>name</td>
                      <td>string</td>
                      <td>Yes</td>
                      <td>Full name of the user</td>
                    </tr>
                    <tr>
                      <td>email</td>
                      <td>string</td>
                      <td>Yes</td>
                      <td>Valid email address</td>
                    </tr>
                    <tr>
                      <td>phone</td>
                      <td>string</td>
                      <td>Yes</td>
                      <td>Phone number</td>
                    </tr>
                    <tr>
                      <td>password</td>
                      <td>string</td>
                      <td>Yes</td>
                      <td>Minimum 6 characters</td>
                    </tr>
                    <tr>
                      <td>password_confirmation</td>
                      <td>string</td>
                      <td>Yes</td>
                      <td>Must match password</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="endpoint-card">
            <div class="endpoint-header">
              <span class="method post">POST</span>
              <span class="endpoint-url">/api/login</span>
              <span class="badge bg-success">Public</span>
            </div>
            <div class="endpoint-body">
              <h5>Authenticate user</h5>
              <p>Authenticates a user and returns a JWT token for accessing protected endpoints.</p>
              
              <ul class="nav nav-tabs" id="loginTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="login-request-tab" data-bs-toggle="tab" data-bs-target="#login-request" type="button" role="tab">Request</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="login-response-tab" data-bs-toggle="tab" data-bs-target="#login-response" type="button" role="tab">Response</button>
                </li>
              </ul>
              
              <div class="tab-content">
                <div class="tab-pane fade show active" id="login-request" role="tabpanel">
                  <div class="example-request">
                    <button class="copy-btn" onclick="copyToClipboard('login-request-code')"><i class="far fa-copy"></i> Copy</button>
                    <pre id="login-request-code"><code>{
  "email": "john@example.com",
  "password": "secret123"
}</code></pre>
                  </div>
                </div>
                <div class="tab-pane fade" id="login-response" role="tabpanel">
                  <div class="example-request">
                    <button class="copy-btn" onclick="copyToClipboard('login-response-code')"><i class="far fa-copy"></i> Copy</button>
                    <pre id="login-response-code"><code>{
  "message": "Login successful",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "08012345678"
  }
}</code></pre>
                  </div>
                </div>
              </div>
              
              <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-triangle me-2"></i> The JWT token should be included in the <code>Authorization</code> header for all protected requests as: <code>Authorization: Bearer YOUR_TOKEN_HERE</code>
              </div>
            </div>
          </div>
        </section>

        <section id="events" class="api-section">
          <h2><i class="fas fa-calendar-check feature-icon"></i> Event Management</h2>
          <p>All event endpoints require authentication. Include the JWT token in the Authorization header.</p>
          
          <div class="endpoint-card">
            <div class="endpoint-header">
              <span class="method post">POST</span>
              <span class="endpoint-url">/api/events/store</span>
              <span class="badge badge-auth">JWT Required</span>
            </div>
            <div class="endpoint-body">
              <h5>Create a new event</h5>
              <p>Creates a new event associated with the authenticated user.</p>
              
              <ul class="nav nav-tabs" id="createEventTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="create-request-tab" data-bs-toggle="tab" data-bs-target="#create-request" type="button" role="tab">Request</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="create-response-tab" data-bs-toggle="tab" data-bs-target="#create-response" type="button" role="tab">Response</button>
                </li>
              </ul>
              
              <div class="tab-content">
                <div class="tab-pane fade show active" id="create-request" role="tabpanel">
                  <div class="example-request">
                    <button class="copy-btn" onclick="copyToClipboard('create-request-code')"><i class="far fa-copy"></i> Copy</button>
                    <pre id="create-request-code"><code>{
  "title": "Team Meeting",
  "description": "Q2 Planning Session",
  "location": "Zoom Meeting",
  "start_time": "2025-06-25 10:00:00",
  "end_time": "2025-06-25 11:00:00"
}</code></pre>
                  </div>
                </div>
                <div class="tab-pane fade" id="create-response" role="tabpanel">
                  <div class="example-request">
                    <button class="copy-btn" onclick="copyToClipboard('create-response-code')"><i class="far fa-copy"></i> Copy</button>
                    <pre id="create-response-code"><code>{
  "message": "Event created successfully",
  "event": {
    "title": "Team Meeting",
    "description": "Q2 Planning Session",
    "location": "Zoom Meeting",
    "start_time": "2025-06-25T10:00:00.000000Z",
    "end_time": "2025-06-25T11:00:00.000000Z",
    "user_id": 1,
    "updated_at": "2023-07-15T12:45:23.000000Z",
    "created_at": "2023-07-15T12:45:23.000000Z",
    "id": 1
  }
}</code></pre>
                  </div>
                </div>
              </div>
              
              <div class="response-schema">
                <h6>Request Parameters</h6>
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th>Field</th>
                      <th>Type</th>
                      <th>Required</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>title</td>
                      <td>string</td>
                      <td>Yes</td>
                      <td>Event title (max 255 chars)</td>
                    </tr>
                    <tr>
                      <td>description</td>
                      <td>string</td>
                      <td>No</td>
                      <td>Detailed event description</td>
                    </tr>
                    <tr>
                      <td>location</td>
                      <td>string</td>
                      <td>No</td>
                      <td>Event location</td>
                    </tr>
                    <tr>
                      <td>start_time</td>
                      <td>datetime</td>
                      <td>Yes</td>
                      <td>Format: YYYY-MM-DD HH:MM:SS</td>
                    </tr>
                    <tr>
                      <td>end_time</td>
                      <td>datetime</td>
                      <td>Yes</td>
                      <td>Must be after start_time</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="endpoint-card">
            <div class="endpoint-header">
              <span class="method get">GET</span>
              <span class="endpoint-url">/api/events</span>
              <span class="badge badge-auth">JWT Required</span>
            </div>
            <div class="endpoint-body">
              <h5>List all events</h5>
              <p>Returns a paginated list of all events for the authenticated user.</p>
              
              <div class="example-request">
                <button class="copy-btn" onclick="copyToClipboard('list-response-code')"><i class="far fa-copy"></i> Copy</button>
                <pre id="list-response-code"><code>{
  "events": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title": "Team Meeting",
        "description": "Q2 Planning Session",
        "location": "Zoom Meeting",
        "start_time": "2025-06-25T10:00:00.000000Z",
        "end_time": "2025-06-25T11:00:00.000000Z",
        "user_id": 1,
        "created_at": "2023-07-15T12:45:23.000000Z",
        "updated_at": "2023-07-15T12:45:23.000000Z"
      }
    ],
    "first_page_url": "http://atsassignment.up.railway.app/api/events?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://atsassignment.up.railway.app/api/events?page=1",
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "http://atsassignment.up.railway.appapi/events?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "next_page_url": null,
    "path": "http://atsassignment.up.railway.app/api/events",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
  }
}</code></pre>
              </div>
              
              <h6 class="mt-3">Optional Query Parameters</h6>
              <table class="table table-bordered table-sm">
                <thead>
                  <tr>
                    <th>Parameter</th>
                    <th>Type</th>
                    <th>Description</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>page</td>
                    <td>integer</td>
                    <td>Page number for pagination (default: 1)</td>
                  </tr>
                  <tr>
                    <td>per_page</td>
                    <td>integer</td>
                    <td>Items per page (default: 15, max: 100)</td>
                  </tr>
                  <tr>
                    <td>sort_by</td>
                    <td>string</td>
                    <td>Field to sort by (default: start_time)</td>
                  </tr>
                  <tr>
                    <td>sort_order</td>
                    <td>string</td>
                    <td>Sort direction (asc or desc, default: asc)</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="endpoint-card">
            <div class="endpoint-header">
              <span class="method get">GET</span>
              <span class="endpoint-url">/api/events/{id}</span>
              <span class="badge badge-auth">JWT Required</span>
            </div>
            <div class="endpoint-body">
              <h5>Get single event</h5>
              <p>Returns detailed information about a specific event.</p>
              
              <div class="example-request">
                <button class="copy-btn" onclick="copyToClipboard('single-response-code')"><i class="far fa-copy"></i> Copy</button>
                <pre id="single-response-code"><code>{
  "event": {
    "id": 1,
    "title": "Team Meeting",
    "description": "Q2 Planning Session",
    "location": "Zoom Meeting",
    "start_time": "2025-06-25T10:00:00.000000Z",
    "end_time": "2025-06-25T11:00:00.000000Z",
    "user_id": 1,
    "created_at": "2023-07-15T12:45:23.000000Z",
    "updated_at": "2023-07-15T12:45:23.000000Z"
  }
}</code></pre>
              </div>
              
              <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-triangle me-2"></i> Returns 404 Not Found if the event doesn't exist or doesn't belong to the authenticated user.
              </div>
            </div>
          </div>

          <div class="endpoint-card">
            <div class="endpoint-header">
              <span class="method put">PUT</span>
              <span class="endpoint-url">/api/events/{id}</span>
              <span class="badge badge-auth">JWT Required</span>
            </div>
            <div class="endpoint-body">
              <h5>Update an event</h5>
              <p>Updates the specified event. Only the event owner can update it.</p>
              
              <ul class="nav nav-tabs" id="updateEventTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="update-request-tab" data-bs-toggle="tab" data-bs-target="#update-request" type="button" role="tab">Request</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="update-response-tab" data-bs-toggle="tab" data-bs-target="#update-response" type="button" role="tab">Response</button>
                </li>
              </ul>
              
              <div class="tab-content">
                <div class="tab-pane fade show active" id="update-request" role="tabpanel">
                  <div class="example-request">
                    <button class="copy-btn" onclick="copyToClipboard('update-request-code')"><i class="far fa-copy"></i> Copy</button>
                    <pre id="update-request-code"><code>{
  "title": "Updated Team Meeting",
  "description": "Updated Q2 Planning Session",
  "location": "Google Meet"
}</code></pre>
                  </div>
                </div>
                <div class="tab-pane fade" id="update-response" role="tabpanel">
                  <div class="example-request">
                    <button class="copy-btn" onclick="copyToClipboard('update-response-code')"><i class="far fa-copy"></i> Copy</button>
                    <pre id="update-response-code"><code>{
  "message": "Event updated successfully",
  "event": {
    "id": 1,
    "title": "Updated Team Meeting",
    "description": "Updated Q2 Planning Session",
    "location": "Google Meet",
    "start_time": "2025-06-25T10:00:00.000000Z",
    "end_time": "2025-06-25T11:00:00.000000Z",
    "user_id": 1,
    "created_at": "2023-07-15T12:45:23.000000Z",
    "updated_at": "2023-07-15T13:20:45.000000Z"
  }
}</code></pre>
                  </div>
                </div>
              </div>
              
              <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i> You can send any combination of fields to update. Only the sent fields will be modified.
              </div>
            </div>
          </div>

          <div class="endpoint-card">
            <div class="endpoint-header">
              <span class="method delete">DELETE</span>
              <span class="endpoint-url">/api/events/{id}</span>
              <span class="badge badge-auth">JWT Required</span>
            </div>
            <div class="endpoint-body">
              <h5>Delete an event</h5>
              <p>Permanently deletes the specified event. Only the event owner can delete it.</p>
              
              <div class="example-request">
                <button class="copy-btn" onclick="copyToClipboard('delete-response-code')"><i class="far fa-copy"></i> Copy</button>
                <pre id="delete-response-code"><code>{
  "message": "Event deleted successfully"
}</code></pre>
              </div>
              
              <div class="alert alert-danger mt-3">
                <i class="fas fa-exclamation-circle me-2"></i> This action is irreversible. The event will be permanently deleted.
              </div>
            </div>
          </div>
        </section>

        <section id="testing" class="api-section">
          <h2><i class="fas fa-vial feature-icon"></i> Testing the API</h2>
          <p>You can test this API using various tools. Here are some recommended approaches:</p>
          
          <div class="row">
            <div class="col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <h5 class="card-title"><i class="fas fa-code me-2"></i> Using cURL</h5>
                  <p class="card-text">Test the API directly from your command line with cURL commands.</p>
                  <pre><code># Register a new user
curl -X POST http://atsassignment.up.railway.app/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","email":"test@example.com","phone":"08012345678","password":"password","password_confirmation":"password"}'

# Login and store token
TOKEN=$(curl -X POST http://atsassignment.up.railway.app/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}' | jq -r '.token')

# Create an event
curl -X POST http://atsassignment.up.railway.app/api/events/store \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{"title":"Test Event","start_time":"2025-01-01 10:00:00","end_time":"2025-01-01 11:00:00"}'</code></pre>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <h5 class="card-title"><i class="fas fa-cloud me-2"></i> Using Postman</h5>
                  <p class="card-text">Import our Postman collection for easy testing with a GUI interface.</p>
                  <ol>
                    <li>Download <a href="#" class="text-primary">Postman Collection</a></li>
                    <li>Import into Postman</li>
                    <li>Set environment variables:
                      <ul>
                        <li><code>base_url</code> - Your API base URL</li>
                        <li><code>token</code> - JWT token after login</li>
                      </ul>
                    </li>
                  </ol>
                  <div class="text-center">
                    <img src="https://www.postman.com/_ar-assets/images/postman-logo+glyph-320x132.png" alt="Postman" style="height: 40px;">
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="alert alert-success">
            <h5><i class="fas fa-lightbulb me-2"></i> Testing Tips</h5>
            <ul>
              <li>Always test error responses (invalid data, missing fields, etc.)</li>
              <li>Verify authentication requirements by making requests without tokens</li>
              <li>Test edge cases like very long strings or invalid date formats</li>
              <li>Check that users can only access their own events</li>
            </ul>
          </div>
        </section>

        <section id="environment" class="api-section">
          <h2><i class="fas fa-cog feature-icon"></i> Environment Configuration</h2>
          <p>To run this API locally or in production, you'll need to configure these environment variables:</p>
          
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="table-dark">
                <tr>
                  <th>Variable</th>
                  <th>Required</th>
                  <th>Description</th>
                  <th>Example</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><code>APP_KEY</code></td>
                  <td>Yes</td>
                  <td>Laravel application key</td>
                  <td><code>base64:...</code></td>
                </tr>
                <tr>
                  <td><code>JWT_SECRET</code></td>
                  <td>Yes</td>
                  <td>Secret for JWT token generation</td>
                  <td><code>your_jwt_secret_here</code></td>
                </tr>
                <tr>
                  <td><code>DB_CONNECTION</code></td>
                  <td>Yes</td>
                  <td>Database driver (mysql, pgsql, sqlite)</td>
                  <td><code>mysql</code></td>
                </tr>
                <tr>
                  <td><code>DB_HOST</code></td>
                  <td>Yes</td>
                  <td>Database server host</td>
                  <td><code>127.0.0.1</code></td>
                </tr>
                <tr>
                  <td><code>DB_PORT</code></td>
                  <td>Yes</td>
                  <td>Database server port</td>
                  <td><code>3306</code></td>
                </tr>
                <tr>
                  <td><code>DB_DATABASE</code></td>
                  <td>Yes</td>
                  <td>Database name</td>
                  <td><code>event_management</code></td>
                </tr>
                <tr>
                  <td><code>DB_USERNAME</code></td>
                  <td>Yes</td>
                  <td>Database username</td>
                  <td><code>root</code></td>
                </tr>
                <tr>
                  <td><code>DB_PASSWORD</code></td>
                  <td>No</td>
                  <td>Database password</td>
                  <td><code>secret</code></td>
                </tr>
                <tr>
                  <td><code>APP_DEBUG</code></td>
                  <td>No</td>
                  <td>Debug mode (true/false)</td>
                  <td><code>false</code> for production</td>
                </tr>
                <tr>
                  <td><code>APP_URL</code></td>
                  <td>Yes</td>
                  <td>Base URL of your application</td>
                  <td><code>http://atsassignment.up.railway.app</code></td>
                </tr>
              </tbody>
            </table>
          </div>
          
          <div class="alert alert-info mt-3">
            <i class="fas fa-info-circle me-2"></i> For security, never commit your <code>.env</code> file to version control. Use <code>.env.example</code> as a template.
          </div>
        </section>

        <footer class="text-center text-muted my-5">
          <p>Event Management API Documentation - Version 1.0.0</p>
          <p>Generated by Ahmad's Laravel API – Powered by Railway</p>
        </footer>
      </div>
      
      <div class="col-lg-3">
        <div class="quick-nav">
          <div class="card">
            <div class="card-header bg-primary text-white">
              <i class="fas fa-list me-2"></i> Quick Navigation
            </div>
            <div class="list-group list-group-flush">
              <a href="#introduction" class="list-group-item list-group-item-action">Introduction</a>
              <a href="#authentication" class="list-group-item list-group-item-action">Authentication</a>
              <a href="#events" class="list-group-item list-group-item-action">Event Management</a>
              <a href="#testing" class="list-group-item list-group-item-action">Testing the API</a>
              <a href="#environment" class="list-group-item list-group-item-action">Environment Setup</a>
            </div>
          </div>
          
          <div class="card mt-4">
            <div class="card-header bg-success text-white">
              <i class="fas fa-download me-2"></i> Resources
            </div>
            <div class="list-group list-group-flush">
              <a href="#" class="list-group-item list-group-item-action">
                <i class="fas fa-file-code me-2"></i> Postman Collection
              </a>
              <a href="#" class="list-group-item list-group-item-action">
                <i class="fas fa-file-alt me-2"></i> OpenAPI Specification
              </a>
              <a href="#" class="list-group-item list-group-item-action">
                <i class="fab fa-github me-2"></i> GitHub Repository
              </a>
            </div>
          </div>
          
          <div class="card mt-4">
            <div class="card-header bg-info text-white">
              <i class="fas fa-question-circle me-2"></i> Support
            </div>
            <div class="card-body">
              <p>Having trouble with the API?</p>
              <a href="mailto:support@example.com" class="btn btn-sm btn-outline-info w-100 mb-2">
                <i class="fas fa-envelope me-1"></i> Email Support
              </a>
              <a href="#" class="btn btn-sm btn-outline-info w-100">
                <i class="fas fa-book me-1"></i> API Guide
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function copyToClipboard(elementId) {
      const element = document.getElementById(elementId);
      const text = element.innerText;
      navigator.clipboard.writeText(text).then(() => {
        const btn = element.parentElement.querySelector('.copy-btn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
        setTimeout(() => {
          btn.innerHTML = originalText;
        }, 2000);
      });
    }
    
    // Highlight active nav item when scrolling
    document.addEventListener('DOMContentLoaded', function() {
      const sections = document.querySelectorAll('.api-section');
      const navItems = document.querySelectorAll('.quick-nav .list-group-item');
      
      window.addEventListener('scroll', function() {
        let current = '';
        
        sections.forEach(section => {
          const sectionTop = section.offsetTop;
          const sectionHeight = section.clientHeight;
          
          if (pageYOffset >= (sectionTop - 100)) {
            current = section.getAttribute('id');
          }
        });
        
        navItems.forEach(item => {
          item.classList.remove('active');
          if (item.getAttribute('href') === `#${current}`) {
            item.classList.add('active');
          }
        });
      });
    });
  </script>
</body>
</html>