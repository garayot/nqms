# NQMS (National Quality Management System)
## Bislig City Division - Comprehensive Documentation

---

## Table of Contents
1. [Executive Summary](#executive-summary)
2. [Current Process (Before NQMS)](#current-process-before-nqms)
3. [NQMS System Overview](#nqms-system-overview)
4. [Problems Solved](#problems-solved)
5. [System Architecture](#system-architecture)
6. [User Roles & Responsibilities](#user-roles--responsibilities)
7. [Key Features & Modules](#key-features--modules)
8. [Document Revision Workflow](#document-revision-workflow)
9. [User Interface Overview](#user-interface-overview)
10. [System Administration](#system-administration)
11. [Getting Started Guide](#getting-started-guide)
12. [Best Practices](#best-practices)

---

## Executive Summary

The **National Quality Management System (NQMS)** is a comprehensive web-based application developed for the Bislig City Division to streamline document management, control document revisions, and automate the approval workflow for policy documents, forms, and operational procedures.

**Key Statistics:**
- **System Type**: Web Application
- **Framework**: Laravel 11 (PHP 8.4)
- **Database**: Relational Database
- **User Roles**: 4 primary roles (User, Reviewer, Approver, Admin)
- **Primary Purpose**: Document lifecycle management and revision control

---

## Current Process (Before NQMS)

### Manual Document Management Challenges

#### 1. **Unorganized Document Distribution**
- Documents were stored in various locations (emails, shared drives, paper files)
- No central repository or version control
- Difficult to track which version is current
- Multiple copies of the same document with different versions circulating

#### 2. **Unclear Approval Process**
- No standardized workflow for document revisions
- Ad-hoc communication via email or physical routing
- Difficult to track approval status
- No formal audit trail of who reviewed/approved and when
- Repeated back-and-forth communications

#### 3. **Poor Document Traceability**
- Unclear when documents were created, revised, or approved
- No history of document changes
- Difficult to identify who requested changes and why
- Compliance and audit issues
- Cannot quickly determine document precedence

#### 4. **Inefficient Review & Approval**
- Reviewers manually tracked review items
- Approvers had no systematic way to manage pending approvals
- Multiple approval cycles caused delays
- No visibility into the approval pipeline
- Hard to prioritize urgent documents

#### 5. **Form & Template Management**
- Form templates scattered across divisions
- Inconsistent use of forms across the organization
- No centralized location for forms
- Difficult for new employees to find correct forms

#### 6. **Knowledge Management**
- Operational procedures and processes not documented systematically
- New staff struggle to understand processes
- Cross-functional collaboration difficult
- No organizational knowledge base

#### 7. **Compliance & Accountability Issues**
- Cannot demonstrate compliance with policy requirements
- No audit trail for regulatory purposes
- Difficult to track document ownership and responsibility
- Risk of using outdated documents
- Vulnerable to control weaknesses in document management

---

## NQMS System Overview

### What is NQMS?

The National Quality Management System (NQMS) is an integrated, web-based platform that:

1. **Centralizes Document Management**
   - Single source of truth for all organizational documents
   - Organized by document type and functional division
   - Easy search and retrieval

2. **Automates Document Revision Workflow**
   - Streamlined process for requesting document changes
   - Systematic review and approval stages
   - Clear status tracking at every stage

3. **Ensures Quality Control**
   - Designated reviewers verify document accuracy and compliance
   - Approvers ensure alignment with organizational strategy
   - Prevents distribution of unapproved documents

4. **Maintains Audit Trail**
   - Complete history of all document changes
   - Timestamps and responsible parties recorded
   - Compliance-ready documentation
   - Traceability for regulatory requirements

5. **Organizes Organizational Knowledge**
   - Operations manual with process documentation
   - Planning documents by functional division
   - Standardized form templates
   - Institutional knowledge management

### Target Users

- **Department Heads & Staff**: Create and request document revisions
- **QMS Reviewers**: Subject matter experts who review proposed changes
- **QMS Approvers**: Decision-makers who approve final versions
- **Administrative Staff**: Manage templates, forms, and organizational data
- **System Administrators**: Oversee system configuration and user management

---

## Problems Solved

### Problem 1: Document Version Control
**Issue**: Multiple versions of documents in circulation; unclear which is current
**Solution**: NQMS maintains a single, centralized document repository with complete version history. Current version is always clearly marked.

### Problem 2: Approval Workflow Inefficiency
**Issue**: Manual routing, unclear status, delayed approvals, bottlenecks
**Solution**: Automated workflow with clear status indicators, email notifications, and dashboard monitoring for each user role.

### Problem 3: Accountability & Audit Trail
**Issue**: Cannot track who did what and when; poor compliance documentation
**Solution**: Complete audit trail recording all actions (creation, review, approval) with timestamps and user information.

### Problem 4: Document Discoverability
**Issue**: Hard to find relevant documents and forms across the organization
**Solution**: Centralized catalog with advanced search, organized by type and functional division, with clear descriptions.

### Problem 5: Collaboration & Communication Gaps
**Issue**: Unclear feedback loops, redundant communications, missed stakeholders
**Solution**: Integrated review and approval system with documented reasoning, feedback storage, and change history.

### Problem 6: Organizational Process Documentation
**Issue**: Undocumented processes, known only to individual employees
**Solution**: Operations Manual module with hierarchical process documentation (Process Groups → Processes → Sub-Processes).

### Problem 7: Form & Template Management
**Issue**: Inconsistent forms, scattered templates, unclear which to use
**Solution**: Centralized form template management with import/export capabilities and clear documentation.

### Problem 8: Compliance & Risk Management
**Issue**: Cannot demonstrate compliance with quality management standards
**Solution**: Provides documentation infrastructure compliant with quality management system requirements (ISO 9001, etc.).

---

## System Architecture

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    NQMS Web Application                       │
│                    (Laravel 11 / PHP 8.4)                     │
└─────────────────────────────────────────────────────────────┘
                              │
                ┌─────────────┼─────────────┐
                │             │             │
        ┌───────▼────────┐   │      ┌──────▼────────┐
        │   User Layer   │   │      │  Admin Layer  │
        ├───────────────┤   │      ├───────────────┤
        │ • Dashboard   │   │      │ • User Mgmt   │
        │ • Draf Mgmt   │   │      │ • Org Config  │
        │ • Documents   │   │      │ • Processes   │
        │ • Forms       │   │      │ • Templates   │
        └───────────────┘   │      └───────────────┘
                            │
                ┌───────────▼──────────┐
                │   Review/Approval    │
                │   Workflow Engine    │
                └──────────────────────┘
                            │
                ┌───────────▼──────────────────┐
                │  Database Layer              │
                ├──────────────────────────────┤
                │ • Users & Roles              │
                │ • Documents & Revisions      │
                │ • Organizational Structure   │
                │ • Processes & Templates      │
                │ • Audit Trail / History      │
                └──────────────────────────────┘
```

### Core Entities

#### 1. Documents
- Master documents with unique identifiers
- Multiple revisions managed through "Drafs"
- Metadata: type, originating office, location, status

#### 2. Drafs (Document Revisions)
- Requests to create new or revise existing documents
- Complete lifecycle from creation through approval
- Attached files/supporting documents
- Status tracking and history

#### 3. Users & Assignments
- Organizational roles with specific permissions
- Position and office assignments
- Team memberships with designated roles
- Approval authority levels

#### 4. Organizational Structure
- Offices and Functional Divisions
- Teams within divisions
- Positions and reporting hierarchy
- Team leads, members, and secretariat roles

#### 5. Process Documentation
- Process Groups (broad categories)
- Processes (specific work flows)
- Sub-Processes (detailed steps)
- URLs linking to external documentation

#### 6. Planning Documents
- Strategic and operational planning by functional division
- Hierarchical organization
- Version control per division

#### 7. Form Templates
- Standardized forms for data collection
- Import/export capabilities
- Association with document types
- Reusable across the organization

---

## User Roles & Responsibilities

### Role 1: Regular User
**Access Level**: User-specific data

#### Responsibilities:
- **Create Drafs**: Request new documents or revisions to existing documents
- **Upload Attachments**: Submit supporting documentation with requests
- **Provide Justification**: Explain reasons for requested changes
- **Track Status**: Monitor progress of submitted drafs through workflow
- **Access Documentation**: View approved documents and forms
- **Print Documents**: Generate copies of approved documents

#### Permissions:
- Create, edit, view own drafs (until submitted)
- View all approved documents
- Access public forms and templates
- View dashboard with own draf statistics

#### Typical Workflow:
1. Access NQMS Dashboard
2. Create new Draf with document details
3. Specify type, applicability, and change rationale
4. Attach supporting files if needed
5. Submit for review
6. Monitor approval progress on dashboard

---

### Role 2: Reviewer (QMS/Quality Reviewer)
**Access Level**: All assigned review items

#### Responsibilities:
- **Evaluate Requests**: Review submitted drafs for completeness and compliance
- **Provide Feedback**: Document suggestions and required changes
- **Make Recommendations**: Approve or request modifications
- **Ensure Quality**: Verify adherence to organizational standards
- **Facilitate Dialogue**: Work with requestors on revisions
- **Route to Approval**: Forward approved items to approvers

#### Permissions:
- View all submitted drafs requiring review
- Add review comments and recommendations
- Approve/reject with documented reasons
- Request revisions
- Generate review reports

#### Review Criteria:
- **Completeness**: Is all required information provided?
- **Accuracy**: Are statements factually correct?
- **Compliance**: Does it follow organizational standards and policies?
- **Clarity**: Is the content clearly written and understandable?
- **Alignment**: Does it align with other organizational documents?
- **Feasibility**: Can the proposed changes be practically implemented?

#### Typical Workflow:
1. Access Reviewer Dashboard
2. View pending drafs for review
3. Open each draf and examine details
4. Add review comments and assessment
5. Make recommendation (Approve/Deny)
6. Approved items move to approval queue
7. Denied items return to requester with feedback

---

### Role 3: Approver (QMS/Final Approver)
**Access Level**: All items ready for approval

#### Responsibilities:
- **Make Final Decision**: Determine if draf becomes official document
- **Strategic Review**: Ensure alignment with organizational direction
- **Authority**: Have final say on all document approvals
- **Risk Assessment**: Consider compliance and business implications
- **Issue Approval**: Officially release approved documents
- **Communicate Decision**: Notify relevant stakeholders

#### Permissions:
- View all drafs recommended for approval
- View reviewer comments and recommendations
- Approve/reject with final authority
- Issue approved version with effective date
- Generate approval reports

#### Approval Criteria:
- **Reviewer Recommendation**: Was it recommended by reviewers?
- **Strategic Alignment**: Aligns with organizational strategy?
- **Legal Compliance**: Complies with applicable regulations?
- **Operational Feasibility**: Can be operationally implemented?
- **Risk Level**: Acceptable risk profile?
- **Stakeholder Input**: Concerns from key stakeholders addressed?

#### Typical Workflow:
1. Access Approver Dashboard
2. Review pending approvals
3. Examine draf, reviewer comments, and history
4. Make approval decision
5. Set effective date if approved
6. Document rationale for decision
7. Approved documents become active; rejected items return with feedback

---

### Role 4: Administrator (QMS System Admin)
**Access Level**: Full system access

#### Responsibilities:
- **User Management**: Create accounts, assign roles, manage permissions
- **Configuration**: Set up organizational structure and hierarchies
- **System Setup**: Initialize document types, forms, and templates
- **Process Documentation**: Create and maintain operations manual
- **Data Management**: Import/export forms and templates
- **Reporting**: Monitor system usage and compliance
- **Troubleshooting**: Resolve system issues and provide support

#### Permissions:
- User account creation and management
- Role assignment and revocation
- Create/edit document types
- Manage organizational entities (offices, divisions, teams, positions)
- Manage QMS teams and assignments
- Import/manage form templates
- View all system documents and drafs
- Generate administrative reports
- System configuration and settings

#### Administrative Functions:
1. **User Management**
   - Whitelist management (who can access)
   - Role assignment (user, reviewer, approver)
   - Team and position assignment
   - Office and division allocation

2. **Organization Setup**
   - Define offices and functional divisions
   - Create positions in hierarchy
   - Form teams with specialized roles (leads, members, secretariat)
   - Establish reporting relationships

3. **Document Setup**
   - Create document types (policy, procedure, form, etc.)
   - Define document applicability (organization-wide, division, office)
   - Establish document numbering schemes

4. **Process Documentation**
   - Create process groups and processes
   - Document sub-processes with steps
   - Link to external resources
   - Maintain operations manual

5. **Form Management**
   - Import standardized forms and templates
   - Manage form versions
   - Associate forms with document types
   - Make forms available to users

#### Typical Daily Tasks:
- Monitor new user requests
- Assign review/approval authority
- Configure new document types
- Manage form templates
- Generate compliance reports
- Provide system support to users

---

## Key Features & Modules

### Module 1: Document Management

#### Overview
Central repository for all organizational documents with version control and status tracking.

#### Features:
- **Document Repository**
  - Browse all approved documents
  - Search by title, type, code, or location
  - Filter by document type and originating office
  - View document metadata and history

- **Document Types**
  - Policies
  - Procedures
  - Forms & Templates
  - Manuals
  - Guidelines
  - Checklists
  - Custom types as needed

- **Document Status**
  - **Active**: Currently in use (approved and effective)
  - **Obsolete**: No longer in use (superseded by newer version)
  - **Draft**: Under development (not yet approved)

- **Document Access**
  - Public access to approved documents
  - Secure download capabilities
  - Print functionality
  - Offline availability

#### Use Cases:
- Looking up current organizational procedures
- Accessing required forms and templates
- Understanding process flows
- Compliance audits and documentation
- Employee training and onboarding

---

### Module 2: Draf Management (Document Revision Workflow)

#### Overview
Core workflow for requesting, reviewing, and approving document changes.

#### Draf Types:
1. **New Document Request**
   - Requesting creation of entirely new document
   - Fills identified gap in documentation

2. **Document Revision**
   - Requesting updates to existing document
   - Policy changes, procedure updates, form modifications

#### Draf Fields:
- **DRAF Number**: Unique identifier assigned by system
- **Source**: Where request originated (internal department, external, etc.)
- **Request Type**: New document or revision
- **Document Type**: Category of document
- **Applicability**: Scope (organization-wide, division, office)
- **Title**: Document/change title
- **Reference Code**: Document classification code
- **Reason**: Justification for change
- **Attachment**: Supporting documentation
- **Current Revision Number**: If revising existing document

#### Draf Statuses:

| Status | Description | Who Can See | Next Step |
|--------|-------------|-----------|-----------|
| **DRAFT** | User creating but hasn't submitted | Only requester & admin | Submit for review |
| **SUBMITTED** | User submitted, waiting for review | Reviewers, approvers, admin | Review (under admin assignment) |
| **UNDER_REVIEW** | Reviewer is actively reviewing | Reviewer, approver, admin | Complete review |
| **RECOMMENDED_FOR_APPROVAL** | Reviewer approved, sent to approver | Approver, admin | Make approval decision |
| **APPROVED** | Approver gave final approval | Everyone | Completed (now active document) |
| **REVIEW_DISAPPROVED** | Reviewer rejected and returned | Requester, admin | Revise and resubmit |
| **APPROVAL_DISAPPROVED** | Approver rejected and returned | Requester, admin | Revise and resubmit |

#### Workflow Diagram:
```
┌─────────────┐
│   DRAFT     │◄─────────────────┐
│  (Created)  │                  │
└──────┬──────┘                  │
       │ User submits            │
       ▼                         │
┌─────────────────────┐          │
│    SUBMITTED        │          │
│  (Waiting Review)   │          │
└──────┬──────────────┘          │
       │ Admin finds reviewer    │
       ▼                         │
┌─────────────────────┐          │
│   UNDER_REVIEW      │          │
│  (Reviewer reviews) │          │
└────┬────────────┬───┘          │
     │            │              │
  APPROVED    REJECTED───────────┘
     │            │
     ▼            └──► REVIEW_DISAPPROVED
┌──────────────────────┐
│ RECOMMENDED_FOR_     │
│ APPROVAL             │
│ (Awaiting Approver)  │
└──────┬───┬───────────┘
       │   │
   APPROVED DENIED
       │    │
       ▼    └──► APPROVAL_DISAPPROVED ──┐
┌──────────────────┐                    │
│   APPROVED       │                    │
│ (Final approval  │                    │
│  document ready) │                    │
└──────────────────┘      Requester     │
                          revises   ────┘
```

#### Key Features:
- **Revision Tracking**: Complete history of all changes
- **Comments & Feedback**: Reviewers and approvers add notes
- **Attachment Management**: Support for document files
- **Status History**: See all status changes and timestamps
- **Print Functionality**: Generate draf forms for records
- **Reason Tracking**: Document why changes requested

#### Metrics:
- Draf creation date
- Review completion time
- Approval decision time
- Time from submission to approval
- Rejection reasons and patterns

---

### Module 3: Dashboard & Notifications

#### For Regular Users:
- **DRAFs at a Glance**
  - Count of drafs in each status
  - Quick view of recent activity
  - Links to manage drafs

- **Statistics Cards**
  - Drafs in Draft (awaiting submission)
  - Submitted (awaiting review)
  - Under Review (currently reviewing)
  - Approved (successfully completed)
  - Disapproved (rejected and awaiting revision)

- **Recent DRAFs Table**
  - Shows 5 most recent drafs
  - Status, dates, and actions
  - Quick access to details

#### For Reviewers:
- **Review Queue**
  - Pending drafs requiring review
  - Priority indicators
  - Quick access to review form

- **Review Statistics**
  - Total waiting for review
  - Average review time
  - Approved vs. rejected count

- **Action Items**
  - Clear calls-to-action for pending work
  - Time-sensitive items flagged

#### For Approvers:
- **Approval Pipeline**
  - Recommended drafs awaiting decision
  - Age of each pending item
  - Priority sorting

- **Approval Metrics**
  - Total awaiting approval
  - Approval rate and timing
  - Decision trends

#### For Administrators:
- **System Overview**
  - Total documents managed
  - Draf statistics across all statuses
  - Active vs. obsolete documents
  - User activity metrics

- **Configuration Quick Access**
  - Links to all admin functions
  - Key setup areas
  - System health indicators

#### Notifications:
- **Email Notifications**
  - DRAFs assigned for review
  - Review recommendations forwarded to approver
  - Approval decisions (approved/disapproved)
  - Rejection with feedback

- **In-App Notifications**
  - Real-time status updates
  - Action required alerts
  - System messages

---

### Module 4: Organizational Structure

#### Components:

**1. Offices**
- Physical locations or organizational divisions
- Examples: Main Office, Satellite Office 1, Satellite Office 2
- Users assigned to specific offices
- Documents originating from offices

**2. Functional Divisions**
- Specialized units within the organization
- Examples: Finance, HR, Operations, Planning
- Planning documents organized by division
- Functional responsibility areas

**3. Positions**
- Job titles and roles (independent of user)
- Examples: Director, Coordinator, Specialist
- Users assigned to positions
- Organizational hierarchy reference

**4. Teams**
- Groups focused on specific functions
- Examples: QMS Team, Document Review Team
- Special roles within teams:
  - **Team Lead**: Oversees team
  - **Team Member**: Active team participant
  - **Team Secretariat**: Administrative support
- Users can belong to multiple teams with different roles

#### Uses:
- Organizational reference for documents
- Assignment of review/approval authority
- Responsibility hierarchy
- Cross-functional collaboration identification

---

### Module 5: Operations Manual (Processes)

#### Purpose
Document and communicate how organizational processes work.

#### Structure:

**Process Groups** (Top Level)
- Broad categories of work
- Examples:
  - "Human Resource Management"
  - "Financial Management"
  - "Quality Management"
  - "Customer Service"

**Processes** (Middle Level)
- Specific work flows within groups
- Examples under HR Management:
  - "Recruitment and Selection"
  - "Employee Onboarding"
  - "Performance Management"
  - "Payroll Processing"

**Sub-Processes** (Detail Level)
- Detailed steps and procedures
- Examples under "Recruitment":
  - "Job Posting and Advertising"
  - "Application Screening"
  - "Interview Scheduling"
  - "Candidate Selection"
  - "Offer Preparation"

**Features:**
- Hierarchical navigation
- Description of each process step
- Links to external procedures or tools
- Version control and update tracking
- Organizational learning resource

#### Management:
- Administrators create and maintain structure
- Optional external URLs for detailed procedures
- Search across all processes
- Public access to approved processes

---

### Module 6: Planning Documents

#### Purpose
Store strategic and operational planning documents by functional division.

#### Organization:
- **Functional Division**: Primary grouping (Finance, HR, Operations, etc.)
- **Planning Documents**: Specific plans within each division
  - Annual plans
  - Budget plans
  - Strategic initiatives
  - Departmental objectives
  - Capacity plans

#### Features:
- Version control per division
- Document storage with metadata
- Access by relevant divisions
- Planning document templates

#### Use Cases:
- Annual planning cycle
- Departmental budgeting
- Strategic initiative tracking
- Capacity planning
- Resource allocation documentation

---

### Module 7: Form Templates & Catalog

#### Purpose
Centralize and standardize forms used across the organization.

#### Features:

**Form Management:**
- Upload and store form templates
- Associate with document types
- Version control for forms
- Import templates from CSV
- Export form catalogs

**Form Catalog:**
- Browse all available forms
- Search by form name, type, or code
- Download forms for use
- Print forms directly
- View form details and instructions

**Form Administration:**
- Import CSV templates
- Bulk form management
- Template versioning
- Access control (public/restricted)

**Use Cases:**
- New employee accessing required forms
- Departments standardizing data collection
- Compliance documentation
- Customer/client forms

---

## Document Revision Workflow

### Complete Workflow Example

#### Scenario: Updating Employee Leave Policy

```
Day 1: REQUEST
├─ HR Manager logs in to NQMS
├─ Clicks "Create DRAF"
├─ Fills in form:
│  ├─ Document Type: Policy
│  ├─ Applicability: Organization-wide
│  ├─ Title: "Updated Employee Leave Policy 2026"
│  ├─ Reason: "Align with new labor code requirements"
│  ├─ Attaches:
│  │  ├─ Updated policy document
│  │  └─ Compliance analysis memo
├─ Saves as DRAFT (can edit anytime before submitting)
└─ Clicks "SUBMIT FOR REVIEW"
   └─ Status changes to SUBMITTED

Day 2: ADMIN ROUTING
├─ System notifies Admin of new DRAF
├─ Admin logs in and views DRAF
├─ Admin:
│  ├─ Reviews completeness
│  ├─ Selects QMS Reviewer (e.g., Quality Coordinator)
│  └─ Updates status to UNDER_REVIEW
└─ Email notification sent to QMS Reviewer

Day 3-5: REVIEW PHASE
├─ QMS Reviewer receives notification
├─ Reviewer logs in and opens DRAF
├─ Reviewer examines:
│  ├─ Policy content
│  ├─ Compliance with standards
│  ├─ Alignment with existing policies
│  ├─ Feasibility and clarity
│  └─ Supporting documentation
├─ Reviewer adds comments:
│  ├─ "Policy language is clear and comprehensive"
│  ├─ "Section 3.2 needs clarification on exceptions"
│  ├─ "Compliance with labor code confirmed"
│  └─ "Recommend minor edits in Section 4"
├─ Reviewer makes decision: "RECOMMENDED FOR APPROVAL"
└─ DRAF status changes to RECOMMENDED_FOR_APPROVAL
   └─ Email sent to Approver with reviewer notes

Day 6-7: APPROVAL PHASE
├─ QMS Approver receives notification
├─ Approver reviews:
│  ├─ Original policy change request
│  ├─ Proposed new policy language
│  ├─ Compliance analysis
│  ├─ Reviewer's recommendations
│  └─ Supporting documents
├─ Approver considers:
│  ├─ Strategic alignment
│  ├─ Operational feasibility
│  ├─ Risk implications
│  ├─ Employee impact
│  └─ Stakeholder concerns
├─ Approver makes decision: "APPROVED"
├─ Sets effective date: "October 15, 2026"
├─ Adds final notes:
│  └─ "Approved. Ensures compliance and supports organizational goals."
└─ Status changes to APPROVED

Day 8: COMPLETION
├─ HR Manager is notified of approval
├─ Document is marked as ACTIVE with new version
├─ Old policy version marked OBSOLETE
├─ Policy published to document repository
├─ Email notification to all staff:
│  ├─ New policy is effective immediately
│  ├─ Link to view updated policy
│  └─ Summary of key changes
├─ Complete audit trail recorded
└─ System stores:
   ├─ Request date and requester
   ├─ Reviewer identity and comments
   ├─ Review completion date
   ├─ Approver identity and decision
   ├─ Approval date and effective date
   └─ Full document change history

TIMELINE: 7-10 days (typical)
PARTICIPANTS: Requester, Admin, Reviewer, Approver, All Staff
DOCUMENTATION: Fully audited and traceable
```

### Rejection Workflow

If Reviewer or Approver rejects:

```
Day 5: REVIEW REJECTION
├─ Reviewer opens DRAF
├─ Reviewer identifies issues:
│  ├─ "Language unclear in Section 2"
│  ├─ "Missing compliance statement"
│  └─ "Need clarification on effective date"
├─ Reviewer makes decision: "NEEDS REVISION"
└─ Status changes to REVIEW_DISAPPROVED
   └─ Email sent to HR Manager with detailed feedback

Day 6-7: REVISION
├─ HR Manager receives notification with feedback
├─ HR Manager revises:
│  ├─ Clarifies language in Section 2
│  ├─ Adds compliance statement
│  ├─ Clarifies effective date
│  └─ Updates attachment with revised policy
├─ HR Manager resubmits DRAF
├─ Status changes back to SUBMITTED
└─ Cycle repeats with same or new reviewer
   └─ Eventually either approved or rejected again

TOTAL TIMELINE: 7-14+ days (with revisions)
OUTCOME: Improved document quality through iterative feedback
```

---

## User Interface Overview

### Page 1: Public Home Page

**Purpose**: Introduce NQMS to visitors
**Accessible By**: Everyone (authenticated or not)

**Key Sections:**
- Welcome message and system purpose
- Quick navigation to public resources
- Organization overview
- Links to:
  - QPS (Quality Policy Statement)
  - Organizational structure
  - Operations Manual
  - Planning documents
  - Forms and templates

**Screenshot Placement:** `[Insert screenshot of NQMS home page]`

---

### Page 2: User Dashboard

**Purpose**: Overview of user's drafs and status
**Accessible By**: Regular users
**Route**: `/dashboard` (after login)

**Components:**

**Left Section: Statistics Cards**
- Card 1: DRAFT (0) - Awaiting submission
- Card 2: SUBMITTED (2) - Awaiting review
- Card 3: UNDER REVIEW (1) - Being reviewed
- Card 4: APPROVED (5) - Successfully approved
- Card 5: DISAPPROVED (0) - Rejected, awaiting revision

**Right Section: Recent DRAFs**
- Table showing 5 most recent drafs:
  - Draf Number
  - Document Type & Title
  - Current Status (with color indicator)
  - Date Created
  - Action buttons (View, Edit)

**Action Buttons:**
- "Create New DRAF" button (prominent)
- "View All DRAFs" link

**Information Display:**
- Clear status colors:
  - Gray: DRAFT
  - Blue: SUBMITTED
  - Yellow: UNDER_REVIEW
  - Purple: RECOMMENDED_FOR_APPROVAL
  - Green: APPROVED
  - Red: DISAPPROVED

**Screenshot Placement:** `[Insert screenshot of User Dashboard]`

---

### Page 3: Create/Edit DRAF Page

**Purpose**: Submit document revision requests
**Accessible By**: Regular users
**Route**: `/draf/create` or `/draf/{id}/edit`

**Form Fields:**

**Section 1: Document Information**
- **DRAF Number** (Read-only if existing): Auto-generated
- **Source** (Dropdown):
  - Internal Department
  - External Request
  - Management Directive
  - Compliance Requirement
  - Other

- **Request Type** (Dropdown):
  - New Document
  - Document Revision

- **Document Type** (Dropdown):
  - Select from predefined types
  - Policy
  - Procedure
  - Form
  - Manual
  - Other

- **Applicability** (Dropdown):
  - Organization-wide
  - Division
  - Office
  - Department

**Section 2: Document Details**
- **Document Title** (Text input, required)
  - Example: "Employee Leave Policy"

- **Reference Code** (Text input)
  - Example: "HR-001-2026"

- **Current Revision Number** (If revising)
  - Example: "2"

**Section 3: Justification**
- **Reason Category** (Dropdown, required):
  - Policy Update
  - Compliance Requirement
  - Operational Change
  - Quality Improvement
  - Other

- **Detailed Reason** (Text area, required):
  - Free-form explanation
  - Why this change is needed
  - Business justification
  - Impact on operations

**Section 4: Attachments**
- **Upload File** (File input):
  - Drag-and-drop area
  - Browse file button
  - Supported formats: PDF, DOC, DOCX, XLS, XLSX, etc.
  - File size limits noted

- **Document Preview** (if exists):
  - Shows currently attached file
  - Option to remove or replace

**Section 5: Action Buttons**
- **Save as Draft** (Blue button): Save without submitting
- **Submit for Review** (Green button): Submit and start workflow
- **Cancel** (Gray link): Abandon changes

**Validation:**
- Required fields marked with asterisk (*)
- Real-time validation feedback
- Helpful error messages if validation fails

**Display:**
- Progress indicator showing steps
- Clear section headers
- Help text for complex fields

**Screenshot Placement:** `[Insert screenshot of Create DRAF page]`

---

### Page 4: View DRAF Details Page

**Purpose**: View complete information about a specific draf
**Accessible By**: Requester, reviewer, approver, admin
**Route**: `/draf/{id}` or `/draf/{id}/show`

**Top Section: DRAF Header**
- DRAF Number (large, prominent)
- Current Status (with color-coded badge)
- Status Timeline (visual progress indicator)
- Print button, Download button

**Section 1: DRAF Information (Read-only)**
- Source
- Request Type
- Document Type
- Applicability
- Document Title
- Reference Code
- Current Revision Number (if applicable)

**Section 2: Reason & Justification**
- Reason Category
- Detailed Reason (full text)
- Uploaded Attachment (downloadable link)

**Section 3: Submission Information**
- Requested By: [User Name] (clickable profile)
- Date Requested: [Date/Time]

**Section 4: Review Information** (if in review or approved)
- Reviewed By: [Reviewer Name] (if available)
- Date Reviewed: [Date/Time] (if completed)
- Review Decision: Approved / Needs Revision
- Review Comments: (full text, multi-paragraph)

**Section 5: Approval Information** (if approved or disapproved)
- Approved By: [Approver Name]
- Date Approved: [Date/Time]
- Effective Date: [Date]
- Approved Document: [Link to download]
- Approval Comments: (full text)

**Section 6: History Timeline**
- Visual timeline showing all status changes
- Each event shows:
  - Status change
  - Date and time
  - User responsible
  - Comments if any

**Action Buttons** (context dependent):
- Edit (if user is owner and DRAFT status)
- Submit (if user is owner and DRAFT status)
- Review Form (if reviewer and UNDER_REVIEW status)
- Approval Form (if approver and RECOMMENDED status)
- Print DRAF
- Download Attachment

**Screenshot Placement:** `[Insert screenshot of View DRAF Details]`

---

### Page 5: Reviewer Dashboard

**Purpose**: Manage document reviews
**Accessible By**: Users with Reviewer role
**Route**: `/reviewer/drafs` (restricted access)

**Key Components:**

**Statistics Section:**
- Total Pending Review: [Count]
- Average Review Time: [Days]
- Approval Rate: [Percentage]
- Recent Actions: [Count this period]

**Pending Reviews Table:**
- **DRAF Number**: Link to view
- **Document Title**: What is being reviewed
- **Document Type**: Category
- **Requested By**: Who submitted
- **Date Submitted**: When request came in
- **Days Pending**: How long waiting
- **Priority**: Color-coded based on age
  - Green: Recently submitted
  - Yellow: Medium wait
  - Red: Long wait (urgent)
- **Status**: Shows current workflow status
- **Actions**: "Start Review" button

**Filters:**
- Status filter (all, high priority, pending review)
- Document type filter
- Date range filter
- Sort options (newest, oldest, longest pending)

**Quick Actions:**
- "Review New Items" shortcut to first pending item
- "View Completed Reviews" link

**Notifications:**
- Count of new drafs waiting for review
- Alert badges on documents requiring immediate attention

**Screenshot Placement:** `[Insert screenshot of Reviewer Dashboard]`

---

### Page 6: Review Form Page

**Purpose**: Complete the review and make recommendations
**Accessible By**: Assigned reviewer
**Route**: `/reviewer/drafs/{id}` (read/review mode)

**Header Section:**
- DRAF details (read-only)
- Source, type, title, reason
- Requester information
- Original submission date

**Content Review Area:**
- Display of proposed document changes
- Side-by-side comparison (if revision)
- Key areas to focus on highlighted

**Review Form:**

**Section 1: Review Assessment**
- **Overall Assessment** (Dropdown):
  - Recommendation: Approve
  - Recommendation: Approve with Minor Edits
  - Recommendation: Request Revision (Major)
  - Recommendation: Reject

**Section 2: Review Checklist**
- Checkbox items for quality verification:
  - ☐ Content is accurate and complete
  - ☐ Complies with organizational standards
  - ☐ Aligns with existing policies
  - ☐ Language is clear and professional
  - ☐ Supporting documentation is adequate
  - ☐ No redundancy with existing documents
  - ☐ Practical and implementable
  - ☐ Properly formatted

**Section 3: Detailed Review Comments**
- **Text area**: Comprehensive feedback
  - What was reviewed
  - Strengths identified
  - Issues found
  - Specific sections needing attention
  - Questions for clarification
  - Recommendations for improvement

**Section 4: Specific Comments** (optional sections):
- **Comments by Section**:
  - Section 1: [feedback]
  - Section 2: [feedback]
  - Etc.

- **Technical Issues**:
  - Formatting problems
  - Clarity problems
  - Compliance gaps

**Section 5: Supporting References**
- Links to related policies
- References to standards or regulations
- Related previous approvals

**Action Buttons:**
- **Submit Review with "Approve" Recommendation** (Green)
- **Submit Review with "Revision Needed" Recommendation** (Orange)
- **Submit Review with "Reject" Recommendation** (Red)
- **Save as Draft** (Gray): Save review without finalizing
- **Cancel** (Gray link)

**Confirmation Dialog:**
- Reviewer confirms recommendation
- Lists the reviewer name and date
- Shows receiving approver

**Screenshot Placement:** `[Insert screenshot of Review Form]`

---

### Page 7: Approver Dashboard

**Purpose**: Manage final approval decisions
**Accessible By**: Users with Approver role
**Route**: `/approver/drafs` (restricted access)

**Key Components:**

**Statistics Section:**
- Total Awaiting Approval: [Count]
- Average Approval Time: [Days]
- Approval Rate: [Percentage] Approved vs Rejected
- Recommended Count: [Count]

**Approval Queue Table:**
- **DRAF Number**: Link to view
- **Document Title**: What needs approval
- **Document Type**: Category
- **Requested By**: Originating user
- **Reviewed By**: Reviewer recommendation
- **Days Since Review**: How long pending approval
- **Priority**: Age-based indication
- **Reviewer Recommendation**: Approved/Revision Needed/Reject
- **Status**: Current stage
- **Action**: "View for Approval" button

**Queue Management:**
- List ordered by date received (oldest first)
- Color coding:
  - Green: Recent recommendations
  - Yellow: Pending 3+ days
  - Red: Pending 5+ days (urgent)

**Filters:**
- Status filter
- Urgency filter
- Reviewer filter (by who recommended)
- Document type filter

**Quick Features:**
- "Approve Next" quick button
- "View Completed Approvals" link
- "Bulk Actions" (optional)

**Notifications:**
- New approval count badge
- Urgent items highlighted

**Screenshot Placement:** `[Insert screenshot of Approver Dashboard]`

---

### Page 8: Approval Decision Page

**Purpose**: Make final approval decision
**Accessible By**: Assigned approver
**Route**: `/approver/drafs/{id}` (read/approval mode)

**Header & Context:**
- Complete DRAF details
- Requester and request date
- Reviewer name and recommendation
- Full review comments

**Document Review Section:**
- Display proposed document
- Reviewer feedback highlighted
- Key decision points emphasized

**Approval Form:**

**Section 1: Final Decision**
- **Radio Buttons** (required):
  - ○ APPROVE - Authorize document as official version
  - ○ APPROVE WITH CONDITIONS - Approve pending specific actions
  - ○ REJECT - Return to requester for revision

**Section 2: Effective Date** (if approving):
- **Date picker**: When document becomes effective
- Default: Today or next business day
- Can be future date

**Section 3: Approval Comments**
- **Text area**: Final decision rationale
  - Why approved or rejected
  - Strategic considerations
  - Risk assessment
  - Implementation notes
  - Conditions (if conditional approval)

**Section 4: Implementation Notes** (if approving):
- **Text area**: Optional guidance
  - How to communicate to staff
  - Training requirements
  - Systems to update
  - Timeline for rollout

**Section 5: Communication Template** (optional):
- Pre-filled template for notification email
- Editable message to staff
- Include key changes summary

**Approval Checklist** (informational):
- ✓ Reviewer has recommended
- ✓ Compliance verified
- ✓ Organizational alignment confirmed
- ✓ Stakeholder feedback incorporated

**Action Buttons:**
- **APPROVE** (Green button)
- **REJECT** (Red button)
- **SAVE AS DRAFT** (Gray): Save decision without finalizing
- **CANCEL** (Gray link)

**Approval Confirmation:**
- Shows approver name, date, time
- Summary of decision
- Confirmation of recipients (requester, staff, etc.)

**Screenshot Placement:** `[Insert screenshot of Approval Decision page]`

---

### Page 9: Documents Repository

**Purpose**: Access approved documents
**Accessible By**: All authenticated users
**Route**: `/documents` or `/documents/index`

**Header Section:**
- Title: "Document Repository" or "Approved Documents"
- Search bar (prominent, full-width)

**Search & Filter Section:**
- **Search Box**: Search by title, code, keywords
- **Document Type Filter**: Dropdown with types
- **Status Filter**: Active/Obsolete
- **Originating Office Filter**: By office location
- **Apply Filters Button**

**Results Display:**

**Option A: Card View**
- Each document as a card:
  - Document Type badge (Policy, Procedure, Form, etc.)
  - Title (prominent)
  - Reference Code (smaller text)
  - Originating Office
  - Current Version Number
  - Last Updated Date
  - Status badge (Active/Obsolete)
  - Action buttons: "View", "Download", "Print"

**Option B: Table View**
- Columns: Type, Title, Code, Office, Version, Date Updated, Status
- Rows for each document
- Sortable columns
- Row action buttons

**Display Options:**
- Toggle between Card and Table views
- Results per page selector
- Pagination controls

**Sorting:**
- Most Recent
- Alphabetical
- By Document Type
- By Office

**Pagination:**
- Previous/Next buttons
- Page numbers
- Results count

**Empty State:**
- If no results: "No documents found. Try adjusting your filters."

**Document Detail Modal/Page:**
- When clicking document
- Full details:
  - Complete metadata
  - Full document text/preview
  - Version history
  - Related documents
  - Download/Print buttons

**Screenshot Placement:** `[Insert screenshot of Documents Repository]`

---

### Page 10: Forms & Templates Catalog

**Purpose**: Access and download forms
**Accessible By**: All authenticated users
**Route**: `/forms-templates` or `/documents?type=form`

**Organization:**
- Browse forms by type
- Grid or list layout
- Categories with form counts

**Features:**
- Each form shows:
  - Form name/title
  - Document type category
  - Brief description
  - Associated document type
  - Download button (PDF or Word)
  - Print button
  - Last updated date
  - Version number

**Filters:**
- By Form Type (dropdown)
- By Document Type (dropdown)
- Search by name
- Sort options

**Bulk Actions (optional):**
- Download multiple forms as ZIP
- Print multiple forms

**Screenshot Placement:** `[Insert screenshot of Forms & Templates Catalog]`

---

### Page 11: Organization Structure Page

**Purpose**: View organizational hierarchy
**Accessible By**: All authenticated users
**Route**: `/organization`

**Display:**
- Organizational chart visualization
  - Boxes for each department/office
  - Hierarchical connections shown
  - Clickable elements for details

**Details on Click:**
- Department/Office information
- Responsible manager
- Teams within department
- Contact information
- Planning documents for division

**Alternative View: List**
- Offices listed with:
  - Description
  - Manager/Head
  - Teams
  - Members count
  - Link to details

**Teams Section:**
- QMS Teams (if applicable)
- Team Leads (decision makers/reviewers)
- Team Members (participants)
- Secretariat roles

**Screenshot Placement:** `[Insert screenshot of Organization Structure]`

---

### Page 12: Operations Manual

**Purpose**: Access process documentation
**Accessible By**: All authenticated users
**Route**: `/operations-manual`

**Navigation Structure:**
- Process Groups (collapsible list)
  - Processes (sub-list)
    - Sub-Processes (details page)

**Display:**
- Process Group name
- Count of processes in group
- Expand/collapse functionality

**Process Details:**
- Name and description
- Sub-processes listed
- Links to external resources (if any)
- Last updated date
- Responsible department/team

**Sub-Process Details:**
- Step-by-step breakdown
- Guidelines and best practices
- Related forms/templates
- Contact for questions
- Last updated

**Search:**
- Search across all processes
- Full-text search
- Filter by group

**Screenshot Placement:** `[Insert screenshot of Operations Manual]`

---

### Page 13: Admin Dashboard

**Purpose**: System overview and configuration access
**Accessible By**: Administrators only
**Route**: `/admin` (restricted)

**Quick Stats Section:**
- Total Documents: [Count]
- Active Documents: [Count]
- Obsolete Documents: [Count]
- Total DRAFs: [Count]
  - By Status (Draft, Submitted, Under Review, etc.)
- Total Users: [Count]
- User Breakdown: [By role]

**Quick Access Menu:**
- User Management
- Whitelist Management
- Organization Setup (Offices, Divisions, Teams, Positions)
- Document Types
- Forms & Templates
- Planning Documents
- Operations Manual (Processes)
- System Settings

**Recent Activity:**
- Latest drafs created
- Recent approvals
- New users requiring role assignment
- System alerts or issues

**Easy Navigation:**
- Large clickable buttons to each admin function
- Icons for visual clarity
- Badge counts for items needing attention

**Screenshot Placement:** `[Insert screenshot of Admin Dashboard]`

---

### Page 14: User Management (Admin)

**Purpose**: Manage users and their roles
**Accessible By**: Administrators only
**Route**: `/admin/users`

**User List Table:**
- **Name**: Full name (clickable)
- **Email**: Email address
- **Current Role**: User | Reviewer | Approver
- **Office**: Assigned office
- **Position**: Job title
- **Functional Division**: Department
- **Created Date**: When account created
- **Activities**: 
  - DRAFs created
  - Reviews completed
  - Approvals made
- **Actions**: Dropdown menu
  - Edit Role
  - Disable/Enable Account
  - Reset Password (option)
  - View Activity

**Filters:**
- By Role
- By Office
- By Functional Division
- Search by name/email

**Bulk Actions:**
- Assign role to multiple users
- Disable multiple users
- Export user list

**Role Assignment Interface:**
- Current role displayed
- Radio button selection for new role
- Save button
- Confirmation of change

**Screenshot Placement:** `[Insert screenshot of User Management]`

---

### Page 15: Organizational Setup (Admin)

**Purpose**: Configure organizational structure
**Accessible By**: Administrators only
**Route**: `/admin/` with sub-sections

**Components:**

**1. Offices Management**
- Add new office
- Edit office details
- List existing offices
- Assign users to offices

**2. Functional Divisions Management**
- Add new division
- Edit division information
- Manage planning documents within division
- Department assignment

**3. Positions Management**
- Create job titles/positions
- Edit position details
- Link to organizational hierarchy
- Assign users to positions

**4. Teams Management**
- Create QMS teams
- Add team members with roles:
  - Team Lead
  - Team Member
  - Secretariat
- Remove team members
- Manage team purpose and focus

**5. Whitelist Management**
- Add users to organizational directory
- Email-based whitelist
- Activation status
- Role assignment on approval

**Data Entry Forms:**
- Field validation
- Duplicate prevention
- Required field indicators
- Clear confirmation messages

**List/Table Display:**
- Sortable columns
- Search/filter options
- Edit and delete buttons
- Row-level actions

**Screenshot Placement:** `[Insert screenshot of Admin Organizational Setup]`

---

### Page 16: Document Types Management (Admin)

**Purpose**: Configure document categories
**Accessible By**: Administrators only
**Route**: `/admin/document-types`

**Functionality:**

**Create Document Type:**
- **Name**: Unique type identifier
- **Description**: Explanation of this type
- **Active/Inactive**: Toggle availability
- **Associated Forms**: Link forms to this type
- **Numbering Scheme**: Reference code pattern
- **Default Applicability**: Organization-wide vs. specific

**List of Document Types:**
- Table showing all types
- Columns: Name, Description, Active, Associated Forms, Actions
- Search and filter options
- Edit button (pencil icon)
- Delete button (trash icon)

**Sample Document Types:**
- Policy
- Procedure
- Form/Template
- Manual
- Guideline
- Checklist
- Work Instruction
- Record/Log

**Screenshot Placement:** `[Insert screenshot of Document Types Management]`

---

### Page 17: Forms & Templates Management (Admin)

**Purpose**: Upload and manage form templates
**Accessible By**: Administrators only
**Route**: `/admin/form-templates`

**Features:**

**Upload Options:**
- Single file upload (drag-and-drop)
- CSV bulk import
- Import from existing document

**CSV Import Template:**
- Download template
- Columns: Form Name, Description, Type, File, Version
- Batch upload multiple forms

**Form List Table:**
- Form Name
- Document Type (associated)
- File Name/Link
- Version
- Upload Date
- Last Modified
- Actions

**File Management:**
- View/Preview form
- Download form
- Replace file with new version
- Delete form
- Edit form metadata

**Form Details:**
- Name
- Description
- Document Type (dropdown)
- Associated file(s)
- Version history
- Upload date/user
- Usage count (how many times used)

**Screenshot Placement:** `[Insert screenshot of Forms Management]`

---

### Page 18: Operations Manual Management (Admin)

**Purpose**: Create and manage process documentation
**Accessible By**: Administrators only
**Route**: `/admin/operations-manual`

**Process Groups (Top Level):**
- List all process groups
- Create new group
- Edit group name/description
- Delete group
- View processes in group

**Process Management (Middle Level):**
- Create process within group
- Edit process details
- Link to external resources
- View sub-processes
- Delete process

**Sub-Process Management (Detail Level):**
- Create sub-process within process
- Edit details
- Add step-by-step instructions
- Link to related forms/documents
- Add contact information
- Delete sub-process

**Hierarchical Display:**
- Tree view showing all levels
- Expandable/collapsible sections
- Drag-and-drop reordering (optional)
- Inline editing

**Publishing:**
- Draft/Publish toggle
- Schedule for publication
- Version control per process group

**Screenshot Placement:** `[Insert screenshot of Operations Manual Management]`

---

### Page 19: Planning Documents (Admin)

**Purpose**: Manage planning documents by division
**Accessible By**: Administrators only
**Route**: `/admin/planning-docs`

**Functional Division Selection:**
- List all divisions
- Create new division (if needed)
- Select division to manage

**Planning Documents Management:**
- Within selected division:
  - List existing planning documents
  - Create new planning document
  - Edit document metadata
  - Upload/replace document file
  - View version history
  - Delete document

**Form Fields:**
- Division Name
- Document Name/Title
- Document Type/Category
- File Upload
- Description
- Fiscal Year/Period
- Effective Date
- Status

**Screenshot Placement:** `[Insert screenshot of Planning Documents Management]`

---

## Getting Started Guide

### For Regular Users

#### Step 1: Login
1. Go to application URL
2. Click Login button
3. Select "Login with Google"
4. Authenticate with Google account
5. System verifies user is whitelisted
6. Redirected to dashboard

#### Step 2: Navigate the System
- **Dashboard** (home page after login)
  - Review your statistics
  - See recent DRAFs
  - Identify next actions

- **Create DRAF**
  - Click "Create New DRAF" button
  - Complete form with document details
  - Specify reason for request
  - Attach supporting documents
  - Save as draft or submit

- **Track DRAFs**
  - View all your DRAFs
  - Check status and progress
  - Read reviewer feedback (if provided)
  - Revise and resubmit if rejected

- **Access Documents**
  - Browse Document Repository
  - Search for needed documents
  - Download and print documents
  - View approved forms

#### Step 3: Creating Your First DRAF

**Scenario:** You want to update the "Training Procedures"

1. Click "Create New DRAF"
2. Fill in the form:
   - **Source**: Internal Department
   - **Request Type**: Document Revision
   - **Document Type**: Procedure
   - **Applicability**: Organization-wide
   - **Title**: "Updated Training Procedures 2026"
   - **Reference Code**: "HR-TRN-001"
   - **Reason Category**: Policy Update
   - **Detailed Reason**: 
     ```
     We need to update the training procedures to include:
     - New mandatory online training modules
     - Updated facilitator requirements
     - Revised scheduling guidelines
     These changes align with our 2026 training initiatives.
     ```
3. Click "Choose File" to attach updated procedure document
4. Click "Submit for Review"
5. Status changes to SUBMITTED
6. You receive confirmation email
7. Admin will assign a reviewer within 1-2 business days

#### Step 4: Monitoring Progress
- **SUBMITTED Status**: Waiting for admin to assign reviewer
- **UNDER_REVIEW Status**: Reviewer is evaluating
- **RECOMMENDED_FOR_APPROVAL Status**: Reviewer approved, sent to approver
- **APPROVED Status**: Final approval received, document is now active
- **DISAPPROVED Status**: Changes needed, review feedback provided

---

### For Reviewers

#### Step 1: Access Reviewer Functions
1. Login with reviewer account
2. Dashboard displays "Reviewer" options
3. Click "Review Pending DRAFs" or navigate to `/reviewer/drafs`

#### Step 2: Find Items to Review
1. Reviewer Dashboard shows:
   - Count of pending reviews
   - List of DRAFs awaiting review
   - Priority indicators (older = higher priority)
2. Click on DRAF to open details
3. Review document and supporting materials

#### Step 3: Conduct the Review
1. Examine proposed changes carefully
2. Check against standards and guidelines
3. Assess compliance and feasibility
4. Add detailed comments with:
   - Strengths of proposal
   - Issues identified
   - Required clarifications
   - Recommendations

#### Step 4: Make Recommendation
1. Decide on recommendation:
   - **Approve**: Content is good, forward to approver
   - **Request Revision**: Good overall but needs edits
   - **Reject**: Content does not meet standards
2. Add final comments explaining decision
3. Submit review
4. Approver is notified (if approved)
5. Requester is notified (if revision needed/rejected)

---

### For Approvers

#### Step 1: Access Approval Functions
1. Login with approver account
2. Dashboard displays approvals section
3. Navigate to `/approver/drafs`

#### Step 2: Review Approvals Queue
1. Approver Dashboard shows:
   - DRAFs ready for approval decision
   - Reviewer recommendations
   - Full review comments
   - Days pending approval

#### Step 3: Make Approval Decision
1. For each DRAF:
   - Review proposal details
   - Read reviewer comments
   - Consider strategic implications
   - Check compliance aspects

2. Make decision:
   - **APPROVE**: Authorize as official document
   - **REJECT**: Return to requester for revision

3. Add approval comments:
   - Rationale for decision
   - Implementation considerations
   - Effective date (if approving)
   - Communication guidance

#### Step 4: Communicate Decision
- System sends notification to requester
- If approved: Document becomes active
- If rejected: Requester receives feedback to revise

---

### For Administrators

#### Step 1: Initial System Setup
1. Login with admin account
2. Navigate to Admin Dashboard
3. Complete setup in order:

**A. Organizational Structure**
- Create offices/locations
- Define functional divisions
- Create positions/job titles
- Form QMS teams with roles

**B. Document Configuration**
- Define document types
- Set numbering schemes
- Create form templates
- Import forms from files

**C. Processes Documentation**
- Create process groups
- Add processes to groups
- Document sub-processes
- Add step-by-step instructions

**D. Planning Documents**
- Add planning documents to divisions
- Organize by fiscal year
- Upload document files

#### Step 2: User Management
1. Review whitelist of approved users
2. Assign roles to users:
   - Regular User (default)
   - Reviewer (for QMS review)
   - Approver (for final approval)
   - Admin (system management)
3. Assign users to teams if needed

#### Step 3: Ongoing Management
- **Monitor workflow**: Check status of pending DRAFs
- **Handle assignments**: Assign DRAFs to reviewers as needed
- **System support**: Help users with issues
- **Generate reports**: Track system usage and compliance
- **Configuration updates**: Add new document types, forms, processes as needed

---

## System Administration

### User Roles Overview

#### Regular User Role
- **Capabilities**:
  - Create and submit DRAFs
  - View own DRAFs and progress
  - Access approved documents and forms
  - Print documents

- **Restrictions**:
  - Cannot see others' draft DRAFs
  - Cannot review DRAFs
  - Cannot approve DRAFs
  - Cannot access admin functions

#### Reviewer Role
- **Capabilities**:
  - Perform all user functions
  - Access reviewer dashboard
  - View pending DRAFs for review
  - Add review comments
  - Make approval/rejection recommendations

- **Restrictions**:
  - Cannot make final approvals (only recommendations)
  - Cannot access admin functions

#### Approver Role
- **Capabilities**:
  - Perform all user functions
  - Access approver dashboard
  - View DRAFs ready for approval
  - Make final approval decisions
  - See review comments for context

- **Restrictions**:
  - Cannot perform reviews (separate function)
  - Cannot access admin functions

#### Admin Role
- **Capabilities**:
  - Full system access
  - Perform all user/reviewer/approver functions
  - User management
  - System configuration
  - Generate reports
  - Access all data

- **No restrictions** (except audit logging)

---

### Whitelist Management

**Purpose**: Control who has access to NQMS

**How It Works**:
1. Users attempt to access NQMS
2. System checks if email is whitelisted
3. If whitelisted: User can access after Google login
4. If not whitelisted: Access denied

**Adding Users to Whitelist**:
1. Admin navigates to `/admin/whitelist`
2. Clicks "Add User"
3. Enters email address
4. (Optional) Assign role immediately
5. Saves whitelist entry
6. User can now login Next time they try to access

**Bulk Import Whitelist**:
1. Prepare CSV file with emails
2. Admin uploads CSV
3. System adds all emails to whitelist
4. Users can now access

---

### System Configuration

#### Email Configuration
- Email notifications sent for:
  - DRAF submitted for review
  - Review recommended, sent to approver
  - DRAF approved
  - DRAF rejected (with feedback)

#### Instance/Environment Settings
- Application URL
- Email settings
- File storage configuration
- Backup and maintenance schedules

---

## Best Practices

### For Document Requesters

1. **Be thorough in justification**
   - Explain WHY the change is needed
   - Provide business context
   - Reference compliance requirements if applicable

2. **Include supporting documentation**
   - Attach updated versions of documents
   - Include analysis or research supporting the change
   - Add relevant email correspondence or requirements

3. **Follow established document format**
   - Use approved templates
   - Maintain consistent formatting
   - Include required sections and information

4. **Submit complete drafts**
   - Ensure all sections are complete
   - Proofread for spelling and grammar
   - Verify links and references are accurate

5. **Monitor progress**
   - Check dashboard regularly for status updates
   - Respond quickly to requests for clarification
   - Plan for 7-10 business day approval timeline

6. **Track versions**
   - Note current version number
   - Describe changes clearly in request
   - Maintain previous version information

### For Reviewers

1. **Establish consistent criteria**
   - Use standard checklist for all reviews
   - Document your evaluation process
   - Be fair and objective

2. **Provide constructive feedback**
   - Be specific about issues
   - Suggest improvements, not just problems
   - Reference standards or guidelines
   - Provide examples where helpful

3. **Review promptly**
   - Complete reviews within 3-5 business days
   - Don't let items sit in queue
   - Prioritize based on urgency and complexity

4. **Verify compliance**
   - Check alignment with organizational policies
   - Verify accuracy of content
   - Ensure proper formatting and structure
   - Confirm legal/regulatory compliance

5. **Collaborate when needed**
   - Ask questions if unclear
   - Suggest meeting with requester if major changes needed
   - Coordinate with other reviewers on complex documents

6. **Document reasoning**
   - Explain your recommendations
   - Note any conditions for approval
   - Reference standards or comparable documents

### For Approvers

1. **Trust the review process**
   - Rely on reviewer recommendations
   - Use reviewer comments to inform decision
   - Defer to subject matter expertise

2. **Make timely decisions**
   - Approve/reject within 2-3 business days
   - Notify requesters promptly
   - Set realistic effective dates

3. **Consider organizational impact**
   - Think about cross-functional implications
   - Consider employee impact
   - Assess resource requirements
   - Evaluate risk profile

4. **Communicate clearly**
   - Explain approval rationale
   - Set clear effective dates
   - Provide implementation guidance if needed
   - Specify any conditions or required actions

5. **Maintain strategic alignment**
   - Ensure consistency with strategic initiatives
   - Support quality management objectives
   - Align with organizational values
   - Support stated policies

### For Administrators

1. **Maintain data quality**
   - Keep organizational structure current
   - Update user roles timely
   - Archive obsolete processes/documents
   - Remove inactive users

2. **Support the workflow**
   - Assign DRAFs to reviewers promptly
   - Resolve system issues quickly
   - Provide training to new users
   - Answer questions and provide guidance

3. **Preserve audit trail**
   - Don't delete historical data
   - Maintain change history
   - Ensure compliance documentation
   - Back up system regularly

4. **Monitor usage**
   - Track active users
   - Monitor workflow metrics
   - Identify bottlenecks
   - Report on system health

5. **Keep processes documented**
   - Operations manual current
   - Process documentation complete
   - Form templates up to date
   - Training materials available

6. **Security and compliance**
   - Enforce access controls
   - Monitor user activity
   - Regular backups
   - System updates and patches
   - GDPR/privacy compliance

---

## Workflow Statistics & Metrics

### Key Performance Indicators

**Document Throughput:**
- DRAFs submitted per month
- Approval rate (% approved vs. rejected)
- Cycle time (submission to approval)
- On-time approval percentage

**Review Quality:**
- Revision requests percentage (low is better)
- Average review time
- Reviewer consistency

**Approval Efficiency:**
- Average approval time
- Approval turnaround compliance
- Decision consistency

**Document Portfolio:**
- Total active documents
- Documents reviewed in last 12 months
- Document obsolescence rate
- Update frequency

### Reporting

Administrators can generate:
- Weekly workflow reports
- Monthly approval summaries
- User activity reports
- Document portfolio reports
- Compliance verification reports
- Performance metrics dashboards

---

## Troubleshooting

### Common Issues

**Issue: Can't login**
- Solution: Verify email is whitelisted, check Google account access, clear browser cache

**Issue: DRAF doesn't save**
- Solution: Check file attachment size, ensure all required fields completed, check internet connection

**Issue: Assigned DRAF doesn't appear**
- Solution: Refresh page, check filters, check email notification for confirmation

**Issue: Can't upload attachment**
- Solution: Check file type (only certain types supported), check file size limits, try different file format

**Issue: Documents not printing properly**
- Solution: Use Chrome browser, enable "Print backgrounds", use PDF format, adjust printer settings

**Issue: Search not finding documents**
- Solution: Check wildcard usage, search in title not content, check document status (active vs. obsolete)

---

## Conclusion

The National Quality Management System (NQMS) for Bislig City Division represents a significant step forward in organizational document management and quality control. By automating the revision and approval workflow, centralizing document storage, and maintaining complete audit trails, NQMS enables the organization to:

- **Ensure Quality**: Systematic review and approval processes guarantee document quality
- **Demonstrate Compliance**: Complete audit trails support regulatory and quality management requirements
- **Improve Efficiency**: Automated workflows reduce cycle time and eliminate delays
- **Enable Knowledge Sharing**: Centralized operations manual and documentation
- **Support Growth**: Scalable system for increasing document volumes

By following the guidelines and best practices outlined in this documentation, organizations can maximize the value of NQMS and build a strong quality management culture.

---

## Document Information

**Document**: NQMS System Documentation
**Version**: 1.0
**Date**: October 2026
**Audience**: All NQMS Users
**Classification**: Internal Use

---

**For support or questions, contact your NQMS Administrator**
