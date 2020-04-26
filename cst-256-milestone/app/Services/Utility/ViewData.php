<?php


namespace App\Services\Utility;

use App\Services\Business\AddressService;
use App\Services\Business\EducationService;
use App\Services\Business\ExperienceService;
use App\Services\Business\JobListingService;
use App\Services\Business\JobService;
use App\Services\Business\SkillService;
use App\Services\Business\UserInfoService;
use App\Services\Business\UserService;
use App\Services\Business\AffinityGroupService;
use App\Services\Business\AffinityMemberService;


class ViewData{

    /**
     * Gets all of the data necessary to the user's profile view
     * @param int $userID the user ID of the user profile to be viewed
     * @param ILoggerService $logger
     * @return array [] Associative array of all the information needed to view the user's profile
     * @throws DatabaseException
     */
    public static function getProfileData($userID, ILoggerService $logger){
        
        $logger->info("Entering ViewData.getProfileData()", ['UserID' => $userID]);
        
        // Gets the user's info from the user table, address table, and the info table
        $userService = new UserService();
        $addressService = new AddressService();
        $infoService = new UserInfoService();
        $educationService = new EducationService();
        $experienceService = new ExperienceService();
        $skillService = new SkillService();
        $listingService = new JobListingService();
        $jobService = new JobService();
        
        // Stores the results for the user from all of the tables accessed
        $user = $userService->findByID($userID, $logger);
        $infoResults = $infoService->findByUserID($userID, $logger);
        $addressResults = $addressService->findByUserID($userID, $logger);
        $educationResults = $educationService->findByID($userID, $logger);
        $experienceResults = $experienceService->findByID($userID, $logger);
        $skillResults = $skillService->findByID($userID, $logger);
        $jobResults = $listingService->getAllJobs($logger);
        
        $appliedJobs = [];
        
        foreach($jobResults as $job){
            array_push($appliedJobs, $jobService->getJob($job['IDJOBS'], $logger)['job']);
        }
        
        // Stores all of the needed retrieved data in an associative array to be passed to the user profile view for display
        $data = [
            'ID' => $userID,
            'user' => $user['user'],
            'info' => $infoResults['userInfo'],
            'address' => $addressResults['address'],
            'educations' => $educationResults['education'],
            'experiences' => $experienceResults['experience'],
            'skills' => $skillResults['skills'],
        ];
        
        $logger->info("Exiting ViewData.getProfileData()", ['data' => $data]);
        
        return $data;
    }
    
    //Gets all of the affinity group data for a particular user when viewing the affinity group page
    public static function getAffinityData($userID, ILoggerService $logger){
        
        $logger->info("Entering ViewData.getAffinityData()", ['UserID' => $userID]);
        
        //Creates instances of all the necessary services
        $groupsService = new AffinityGroupService();
        $membersService = new AffinityMemberService();
        $skillService = new SkillService();
        
        //Gets neccessary results from all services
        $owned = $groupsService->getAllOwned($userID, $logger);
        $joined = $membersService->getAllJoined($userID, $logger);
        $all = $groupsService->getAll($logger);
        $skills = $skillService->findByID($userID, $logger);
        $notJoined = [];
        
        //Fills notJoined array with all groups that the user is not a part of
        for($i = 0; $i < count($all); $i++){
            $valid = true;
            $id = $all[$i]['IDAFFINITYGROUPS'];
            
            
            
            foreach($joined as $group){
                if($group['IDAFFINITYGROUPS'] == $id){
                    $valid = false;
                }
            }
            
            if($valid){
                array_push($notJoined, $all[$i]);
            }
        }
        
        $suggested = [];
        
        //Fills the suggested array with all groups that are valid suggestions from the notJoined array
        foreach($skills['skills'] as $skill){
            foreach($notJoined as $group){
                if($group['FOCUS'] == $skill['SKILL']){
                    array_push($suggested, $group);
                }
            }
        }
        
        //Data array to be returned to the view
        $data = [
            'ID' => $userID,
            'owned' => ViewData::addMembersToGroupData($owned, $logger),
            'joined' => ViewData::addMembersToGroupData($joined, $logger),
            'suggested' => ViewData::addMembersToGroupData($suggested, $logger),
            'skills' => $skills['skills']
        ];
        
        $logger->info("Exiting ViewData.getAffinityData()", ['data' => $data]);
        
        return $data;
    }
    
    /*
     * Method for getting all the members in a group and adding them to the existing affinity group array
     * to be returned to the view
     */
    private static function addMembersToGroupData($groups, ILoggerService $logger){
        
        $logger->info("Entering ViewData.addMembersToGroupData()", []);
        
        //Creates instances of necessary business services
        $membersService = new AffinityMemberService();
        $userService = new UserService();
        
        //Fills all the groups with their members
        for($i = 0; $i < count($groups); $i++){
            $members = [];
            $users = $membersService->getAllMembers($groups[$i]['IDAFFINITYGROUPS'], $logger);
            foreach($users as $user){
                $userResults = $userService->findByID($user['USERS_IDUSERS'], $logger)['user'];
                array_push($members, ['ID' => $userResults['IDUSERS'], 'USERNAME' => $userResults['USERNAME']]);
            }
            $groups[$i]['members'] = $members;
        }
        
        $logger->info("Exiting ViewData.addMembersToGroupData()", []);
        
        return $groups;
    }
    
}